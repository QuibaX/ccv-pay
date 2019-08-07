<?php

namespace QuibaX\CCVPay;

class CCVPay
{
    private $baseUrl = '';

    private $apiKey = '';

    /**
     * Create a new Skeleton Instance.
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Friendly welcome.
     *
     * @param string $phrase Phrase to return
     * @return string Returns the phrase passed in
     */
    public function echoPhrase($phrase)
    {
        return $phrase;
    }
}
