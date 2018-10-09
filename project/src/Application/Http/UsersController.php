<?php

declare(strict_types=1);

namespace Application\Http;

use Application\JsonApiControllerInterface;
use Application\Security\Gate;
use Application\TokenAuthenticatedControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users")
 */
final class UsersController implements
    JsonApiControllerInterface,
    TokenAuthenticatedControllerInterface
{
    /**
     * @Route(methods={"GET"})
     */
    public function collection(
        Gate $gate,
        Request $request
    ) {
        $gate->validatePermissions('ROLE_ADMIN');
    }
}
