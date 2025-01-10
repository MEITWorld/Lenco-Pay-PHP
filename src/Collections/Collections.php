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

    public function getCollection(string $paymentReference): object
    {
        try {
            $response = $this->client->request('GET', 'https://api.lenco.co/access/v2/collections/status/' . $paymentReference, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->privateKey,
                    'accept' => 'application/json',
                ],
            ]);

            $body = $response->getBody();
            $jsonData = json_decode($body);

            // Check for JSON decoding errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response: ' . json_last_error_msg());
            }

            return $jsonData;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle HTTP request errors
            return (object) [
                'success' => false,
                'error' => 'HTTP Request Error: ' . $e->getMessage(),
            ];
        } catch (\Exception $e) {
            // Handle other errors
            return (object) [
                'success' => false,
                'error' => 'Error: ' . $e->getMessage(),
            ];
        }
    }

}