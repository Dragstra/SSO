<?php

declare(strict_types=1);

namespace App\Bundles\SingleSignOnBundle\Implementation\CustomerY;

use App\Bundles\SingleSignOnBundle\Contract\AbstractProvider;
use App\Bundles\SingleSignOnBundle\Implementation\CustomerY\Service\AfasService;
use App\Entity\Auth\BearerToken;
use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class CustomerYProvider
 *
 * @package App\Bundles\SingleSignOnBundle\Implementation\CustomerY\Service
 */
class CustomerYProvider extends AbstractProvider
{
    private AfasService $afasService;

    public function __construct(
        EntityManagerInterface $entityManager,
        ParameterBagInterface $parameterBag,
        AfasService $afasService
    ) {
        parent::__construct($entityManager, $parameterBag);
        $this->afasService = $afasService;
    }

    /**
     * Custom login where the logic is copied like the old system had.
     *
     * @param Request $request
     * @return BearerToken
     * @throws Exception
     * @throws TransportExceptionInterface
     */
    public function login(Request $request): BearerToken
    {
        $employee = $this->entityManager->getRepository(Employee::class)->findOneBy(
            ['employeeNumber' => $request->get('code')]
        );

        $this->afasService->getData($request, $this->parameterBag->get('cert_dir'), $this->parameterBag->get('customer_y'));
        if (!$employee || !$user = $employee->getPerson()->getUser()) {
            throw new UserNotFoundException('No user found.');
        }

        return $this->setBearerToken($user);
    }
}
