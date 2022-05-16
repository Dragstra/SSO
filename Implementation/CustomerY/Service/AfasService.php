<?php

declare(strict_types=1);

namespace App\Bundles\SingleSignOnBundle\Implementation\CustomerY\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class AfasService
 *
 * @package App\Bundles\SingleSignOnBundle\Implementation\CustomerY\Service
 */
class AfasService
{
    public const CA_CERT = 'cacert_new.pem';

    /**
     * @param Request $request
     * @param string $path
     * @param string $privateKey
     * @return void
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getData(Request $request, string $path, string $privateKey): array
    {
        $url = (string)urldecode($request->get('tokenurl'));
        $client = HttpClient::create();

        return $client->request('POST', $url, [
            'capath' => $path,
            'body' => [
                'secret' => $privateKey,
                'code' => $request->get('code'),
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'secret' => $privateKey,
            ],
        ])->getContent();
    }
}
