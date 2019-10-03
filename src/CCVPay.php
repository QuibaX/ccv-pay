<?php

namespace QuibaX\CCVPay;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use QuibaX\CCVPay\Objects\Transaction;

class CCVPay
{
    private $baseUrl = 'https://redirect.jforce.be/api/v1';

    private $apiKey = '';

    private $client;

    /**
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;

        $this->client = new Client([
            'auth' => [$this->apiKey, ''],
            'headers' => ['Content-Type' => 'application/json']
        ]);
    }

    private function post($url, $data = []) {
        return $this->client->post($this->baseUrl . $url, [
            'json' => $data
        ]);
    }

    private function get($url, $params = []) {
        return $this->client->get($this->baseUrl . $url, $params);
    }

    public function getAvailableMethods() {
        return json_decode($this->get('/method')->getBody()->getContents());
    }

    public function getTransaction($transactionReference) {
        try {
            return Transaction::getByObject(json_decode($this->get('/transaction?reference=' . $transactionReference)->getBody()->getContents()));
        } catch(ClientException $clientException) {
            if(class_exists("\Sentry")) {
                \Sentry::captureException($clientException);
            }
            return false; // Probably an invalid transaction
        }
    }

    /**
     * @param $amount
     * @param $returnUrl
     * @param $paymentMethod
     * @param null $metadata
     * @param null $merchantOrderReference
     * @param string $language (eng/fra/deu/nld)
     * @return Transaction | false
     */
    public function createPayment($amount, $returnUrl, $paymentMethod, $webhookUrl, $metadata = null, $merchantOrderReference = null, $description = '', $language = 'eng') {
        try {
            $request = $this->post('/payment', [
                "method" => "card",
                "brand" => $paymentMethod,
                "language" => $language,
                "currency" => "eur",
                "returnUrl" => $returnUrl,
                "amount" => $amount,
                "metadata" => $metadata,
                "merchantOrderReference" => $merchantOrderReference,
                "webhookUrl" => $webhookUrl,
                "description" => $description
            ]);

            return Transaction::getByObject(json_decode($request->getBody()->getContents()));
        } catch (ClientException $clientException) {
            if(class_exists("\Sentry")) {
                \Sentry::captureException($clientException);
            }
            return false;
        }
    }
}
