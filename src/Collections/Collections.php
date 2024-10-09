<?php

namespace Lenco\Collections;

use \GuzzleHttp\Client;

class Collections
{
    // Declare private variables
    private string $privateKey;
    private string $publicKey;
    protected Client $client;

    // Constructor to initialize the class properties
    public function __construct(string $privateKey)
    {
        $this->client = new Client();
        $this->privateKey = $privateKey;
    }

    public function getCollection(string $paymentReference): string
    {
        $response = $this->client->request('GET', 'https://api.lenco.co/access/v2/collections/status/' . $paymentReference, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->privateKey,
                'accept' => 'application/json',
            ],
        ]);

        $body = $response->getBody();
        $jsonData = json_decode($body, true);
        return $jsonData;
    }
}