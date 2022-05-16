<?php

declare(strict_types=1);

namespace App\Bundles\SingleSignOnBundle\Controller;

use App\Bundles\SingleSignOnBundle\Context\SingleSignOnContext;
use App\Bundles\SingleSignOnBundle\Exception\SingleSignOnException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SingleSignOnController
 *
 * @package App\Bundles\SingleSignOnBundle\Controller
 */
class SingleSignOnController extends AbstractController
{
    /**
     * Custom logic where we hook into the normal login process.
     *
     * If authenticated, redirect to a certain route where it hooks into the frontend which will create an accessToken
     * and handle the rest.
     *
     * @Route("/SSO", name="SSO", methods={"GET"}, format="json")
     *
     * @param Request $request
     * @param SingleSignOnContext $provider
     * @return RedirectResponse
     * @throws SingleSignOnException if no providers are available or the user isn't authenticated
     */
    public function login(Request $request, SingleSignOnContext $provider): RedirectResponse
    {
        $bearerToken = $provider->handleLogin($request);

        $url = $this->getParameter('frontend_url') . '/token/' . $bearerToken->getToken();

        return $this->redirect($url);
    }
}
