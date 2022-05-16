<?php

declare(strict_types=1);

namespace App\Bundles\SingleSignOnBundle\Contract;

use App\Entity\Auth\BearerToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract class AbstractProvider
 *
 * @package App\Bundles\SingleSignOnBundle\Contract
 */
abstract class AbstractProvider implements SingleSignOnInterface
{
    protected EntityManagerInterface $entityManager;

    protected ParameterBagInterface $parameterBag;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag)
    {
        $this->entityManager = $entityManager;
        $this->parameterBag = $parameterBag;
    }

    abstract public function login(Request $request): BearerToken;

    /**
     * @param Request $request
     * @return bool
     */
    public function isAvailable(Request $request): bool
    {
        $reflectionClass = new ReflectionClass($this);
        $className = strtolower(str_replace('Provider', '', $reflectionClass->getShortName()));

        return strtolower($request->get('provider')) === $className;
    }

    /**
     * @param User $user
     * @return BearerToken
     * @throws Exception
     */
    public function setBearerToken(User $user): BearerToken
    {
        $expirationDate = $this->parameterBag->get('bearer_expiration_ime');
        $bearerToken = new BearerToken((int)$expirationDate);
        $bearerToken->setUser($user);

        $this->entityManager->persist($bearerToken);
        $this->entityManager->flush();

        return $bearerToken;
    }
}
