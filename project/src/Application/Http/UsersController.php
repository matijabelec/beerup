<?php

declare(strict_types=1);

namespace Application\Http;

use Application\JsonApiControllerInterface;
use Application\Security\Gate;
use Application\TokenAuthenticatedControllerInterface;
use Domain\User\Service\BrowseUserService;
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
        BrowseUserService $browseUserService
    ) {
        $gate->validatePermissions('ROLE_ADMIN');

        return $browseUserService->browse();
    }
}
