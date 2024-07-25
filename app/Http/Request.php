<?php

namespace HopHey\Trademarks\Http;

use GuzzleHttp\Client;

class Request
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'cookies' => true,
            'verify' => false,
        ]);
    }

    public function get(string $url): string
    {
        $response = $this->client->get($url);
        return (string) $response->getBody();
    }

    public function post(string $url, array $formParams): string
    {
        $response = $this->client->post($url, [
            'form_params' => $formParams,
        ]);
        return (string) $response->getBody();
    }
}