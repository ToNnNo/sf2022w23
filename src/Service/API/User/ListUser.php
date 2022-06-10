<?php

namespace App\Service\API\User;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ListUser
{
    private $baseApiUrl;
    private $httpClient;

    public function __construct(string $baseApiUrl, HttpClientInterface $httpClient)
    {
        $this->baseApiUrl = $baseApiUrl;
        $this->httpClient = $httpClient;
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function findAll(): array
    {
        $response = $this->httpClient->request('GET', $this->baseApiUrl.'/users');

        return $response->toArray();
    }
}
