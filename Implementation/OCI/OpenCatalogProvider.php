<?php

declare(strict_types=1);

namespace App\Bundles\SingleSignOnBundle\Implementation\OCI;

use App\Bundles\SingleSignOnBundle\Contract\AbstractProvider;
use App\Bundles\SingleSignOnBundle\Exception\SingleSignOnException;
use App\Entity\Auth\BearerToken;
use App\Entity\User;
use App\Exception\AccessException;
use Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OpenCatalogInterfaceProvider
 *
 * @package App\Bundles\SingleSignOnBundle\Implementation\OCI
 */
class OpenCatalogProvider extends AbstractProvider
{
    /**
     * @param Request $request
     * @return BearerToken
     * @throws Exception
     */
    public function login(Request $request): BearerToken
    {
        $repository = $this->entityManager->getRepository(User::class);
        if (!$request->get('token') || !$user = $repository->findOneBy(['token' => $request->get('token')])) {
            throw new AccessException('Access denied.');
        }

        if (!$request->get('hook_url')) {
            throw new SingleSignOnException('No hook url found.');
        }

        return $this->setBearerToken($user);
    }
}
