<?php

namespace Application\Security;

use Symfony\Component\HttpFoundation\RequestStack;

final class Gate
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        RequestStack $requestStack
    ) {
        $this->requestStack = $requestStack;
    }

    /**
     * @param string|string[] $permissions
     * @throws UnauthorizedException
     */
    public function validatePermissions(
        $permissions
    ): void {
        $request = $this->requestStack->getCurrentRequest();

        $authRole = $request->attributes->get('_auth.role', null);

        if (true === is_array($permissions)) {
            if (false === in_array($authRole, $permissions, true)) {
                throw $this->throwUnauthorized();
            }
        } else {
            if ((string) $permissions !== $authRole) {
                throw $this->throwUnauthorized();
            }
        }
    }

    private function throwUnauthorized(): UnauthorizedException
    {
        return new UnauthorizedException();
    }

    public function getAuthUserId(): ?int
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request->attributes->get('_auth.userId', null);
    }
}
