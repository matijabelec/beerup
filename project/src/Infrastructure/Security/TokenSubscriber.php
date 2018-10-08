<?php

declare(strict_types=1);

namespace Infrastructure\Security;

use Application\JsonApiControllerInterface;
use Application\TokenAuthenticatedControllerInterface;
use Infrastructure\Security\Jwt\TokenParser;
use Infrastructure\Security\Jwt\TokenVerifier;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

final class TokenSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenParser
     */
    private $tokenParser;

    /**
     * @var TokenVerifier
     */
    private $tokenVerifier;
    /**
     * @var Security
     */
    private $security;

    public function __construct(
        TokenParser $tokenParser,
        TokenVerifier $tokenVerifier,
        Security $security
    ) {
        $this->tokenParser = $tokenParser;
        $this->tokenVerifier = $tokenVerifier;
        $this->security = $security;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (false === is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof TokenAuthenticatedControllerInterface) {
            $authorizationHeader = $event->getRequest()->headers->get('Authorization', '');

            if (1 !== preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
                throw new AccessDeniedHttpException('Token is missing!');
            }

            $tokenPayload = $matches[1];

            $token = $this->tokenParser->parse($tokenPayload);

            if (false === $this->tokenVerifier->verify($token)) {
                throw new AccessDeniedHttpException('Token is invalid!');
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
