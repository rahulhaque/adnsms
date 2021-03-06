<?php

namespace AdnSms;

abstract class AbstractAdnSms
{
    protected $apiKey;
    protected $apiSecret;
    protected $config;
    protected $recipient;
    protected $message;
    protected $campaignTitle;
    protected $apiUrl;
    protected $requestType;
    protected $messageType = 'TEXT';
    private $allowedRequestTypes = [
        'SINGLE_SMS', 'OTP', 'GENERAL_CAMPAIGN', 'MULTIBODY_CAMPAIGN'
    ];
    private $allowedMessageTypes = [
        'TEXT', 'UNICODE'
    ];

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    protected function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    protected function getApiKey()
    {
        return $this->apiKey;
    }

    protected function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;
    }

    protected function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * Required
     *
     * @param $requestType
     * @throws \Exception
     */
    protected function setRequestType($requestType)
    {
        if (!in_array(strtoupper($requestType), $this->allowedRequestTypes)) {
            throw new \Exception('Invalid request type. Must be one of ' . implode(', ', $this->allowedRequestTypes) . '.');
        }

        $this->requestType = $requestType;
    }

    /**
     * @return string
     */
    protected function getRequestType()
    {
        return $this->requestType;
    }

    protected function setApiUrl($url)
    {
        $this->apiUrl = $this->config['domain'] . $url;
    }

    /**
     * @return mixed
     */
    protected function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param $messageType
     */
    protected function setMessageType($messageType)
    {
        if (!in_array(strtoupper($messageType), $this->allowedMessageTypes)) {
            throw new \Exception('Invalid message type. Must be one of ' . implode(', ', $this->allowedMessageTypes) . '.');
        }

        $this->messageType = $messageType;
    }

    /**
     * Required
     *
     * @return string
     */
    protected function getMessageType()
    {
        return $this->messageType;
    }

    /**
     * @return mixed
     */
    protected function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param $recipient
     */
    protected function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return mixed
     */
    protected function getMessageBody()
    {
        return $this->message;
    }

    /**
     * @param $message
     */
    protected function setMessageBody($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    protected function getCampaignTitle()
    {
        return $this->campaignTitle;
    }

    /**
     * @param $campaignTitle
     */
    protected function setCampaignTitle($campaignTitle)
    {
        $this->campaignTitle = $campaignTitle;
    }

    /**
     * Make request to api and return response
     *
     * @param $data
     * @return mixed|string
     */
    protected function callToApi($data)
    {
        $header = array(
            "Accept: application/json",
            "Content-type:text/xml; charset=utf-8"
        );

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $this->getApiUrl());
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
