<?php

declare(strict_types=1);

namespace App\Bundles\SingleSignOnBundle\Context;

use App\Bundles\SingleSignOnBundle\Contract\SingleSignOnInterface;
use App\Bundles\SingleSignOnBundle\DependencyInjection\Compiler\LoadSingleSignOnProvidersCompilerPass;
use App\Bundles\SingleSignOnBundle\Exception\SingleSignOnException;
use App\Entity\Auth\BearerToken;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SingleSignOnContext
 *
 * @package App\Bundles\SingleSignOnBundle\Context
 */
class SingleSignOnContext
{
    private array $providers = [];

    /**
     * The CompilerPass makes sure the container will set the providers whenever it gets injected.
     * @see LoadSingleSignOnProvidersCompilerPass
     *
     * @param SingleSignOnInterface $provider
     * @return void
     */
    public function addProvider(SingleSignOnInterface $provider): void
    {
        $this->providers[] = $provider;
    }

    /**
     * Check each provider if it can be used for login.
     *
     * Strategy pattern used
     *
     * @param Request $request
     * @return BearerToken
     * @throws SingleSignOnException
     */
    public function handleLogin(Request $request): BearerToken
    {
        /** @var SingleSignOnInterface $provider */
        foreach ($this->providers as $provider) {
            if ($provider->isAvailable($request)) {
                return $provider->login($request);
            }
        }

        throw new SingleSignOnException('No SSO provider found.');
    }
}
