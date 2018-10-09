<?php

declare(strict_types=1);

namespace Infrastructure\Response;

use Application\Response\Response;
use Application\Security\UnauthorizedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiResponseSubscriber implements EventSubscriberInterface
{
    /**
     * @var ApiResponseFactory
     */
    private $apiResponseFactory;

    /**
     * @var array
     */
    private $statuses;

    public function __construct(
        ApiResponseFactory $apiResponseFactory,
        array $statuses
    ) {
        $this->apiResponseFactory = $apiResponseFactory;
        $this->statuses = $statuses;
    }

    public function onKernelViewResponse(GetResponseForControllerResultEvent $event)
    {
        $controllerResult = $event->getControllerResult();

        if (
            false === $controllerResult
            ||
            null === $controllerResult
        ) {
            $event->setResponse(new JsonResponse(null, 204));
            return;
        }

        $resource = $controllerResult;
        $fields = [];

        if ($controllerResult instanceof Response) {
            $resource = $controllerResult->getResource();
            $fields = $controllerResult->getFields();
        }

        $response = $this->apiResponseFactory->createResourceResponse($resource, $fields);

        $event->setResponse($response);
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        switch (true) {
            case ($exception instanceof NotFoundHttpException):
                return;
            case ($exception instanceof AccessDeniedHttpException):
                $exception = new UnauthorizedException();
        }

        $code = $exception->getCode();

        $status = 500;
        $title = 'Internal Server Error';
        $detail = $exception->getMessage();

        if (true === isset($this->statuses[$code])) {
            $status = $this->statuses[$code]['status'] ?? 500;
            $title = $this->statuses[$code]['title'] ?? '';
        }

        $response = $this->apiResponseFactory
            ->createErrorResponse($status, $title, $detail);

        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => 'onKernelViewResponse',
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
