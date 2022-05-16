<?php

declare(strict_types=1);

namespace App\Bundles\SingleSignOnBundle\Implementation\SAML;

use App\Bundles\SingleSignOnBundle\Contract\AbstractProvider;
use App\Entity\Auth\BearerToken;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CustomerXProvider
 *
 * @package App\Bundles\SingleSignOnBundle\Implementation\SAML
 */
class CustomerXProvider extends AbstractProvider
{

    public function login(Request $request): BearerToken
    {
        // TODO: Implement login() method.
    }
}
