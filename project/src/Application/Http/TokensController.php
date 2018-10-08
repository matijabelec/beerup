<?php

declare(strict_types=1);

namespace Application\Http;

use Application\JsonApiControllerInterface;
use Application\Request\RequestContentValidator;
use Application\Security\Jwt\Token;
use Domain\User\Service\UserDetailService;
use Infrastructure\Response\ApiResponseFactory;
use Infrastructure\Security\Jwt\TokenFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tokens")
 */
final class TokensController implements JsonApiControllerInterface
{
    /**
     * @var ApiResponseFactory
     */
    private $apiResponseFactory;

    public function __construct(
        ApiResponseFactory $apiResponseFactory
    ) {
        $this->apiResponseFactory = $apiResponseFactory;
    }

    /**
     * @Route(methods={"POST"})
     */
    public function login(
        TokenFactory $tokenFactory,
        UserDetailService $userDetailService,
        RequestContentValidator $requestContentValidator,
        Request $request
    ): Token {
        $data = $requestContentValidator->validateData($request->getContent(), [ 'username', ]);

        $user = $userDetailService->fetchByUsername((string) $data['username']);
        $token = $tokenFactory->create($user->getUserId()->getId());

        return $token;
    }
}
