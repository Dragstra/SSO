<?php

declare(strict_types=1);

namespace App\Bundles\SingleSignOnBundle\Contract;

use App\Entity\Auth\BearerToken;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SingleSignOnInterface
 *
 * @package App\Bundles\SingleSignOnBundle\Contract
 */
interface SingleSignOnInterface
{
    public function login(Request $request): BearerToken;

    public function isAvailable(Request $request): bool;
}
