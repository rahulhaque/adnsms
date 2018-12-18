<?php

namespace AdnSms;

require_once(__DIR__ . '/AbstractAdnSms.php');

class AdnSms extends AbstractAdnSms
{
    /**
     * AdnSms constructor.
     */
    public function __construct($api_key, $api_secret)
    {
        $this->setConfig(include(__DIR__ . '/config.php'));
        $this->setApiKey($api_key);
        $this->setApiSecret($api_secret);
    }

    /**
     * Check remaining sms
     *
     * @return mixed|string
     */
    public function checkBalance()
    {
        $this->setApiUrl($this->config['apiUrl']['check_balance']);

        $data = [
            'api_key' => $this->getApiKey(),
            'api_secret' => $this->getApiSecret()
        ];

        return $this->callToApi($data);
    }

    /**
     * Send single sms to single recipients
     *
     * @param $requestType
     * @param $message
     * @param $recipient
     * @param $messageType
     * @param null $campaignTitle
     * @return mixed|string
     * @throws \Exception
     */
    public function sendSms($requestType, $message, $recipient, $messageType, $campaignTitle = null)
    {
        $this->setApiUrl($this->config['apiUrl']['send_sms']);
        $this->setRequestType($requestType);
        $this->setMessageBody($message);
        $this->setRecipient($recipient);
        $this->setMessageType($messageType);
        $this->setCampaignTitle($campaignTitle);

        $data = [
            'api_key' => $this->getApiKey(),
            'api_secret' => $this->getApiSecret(),
            'request_type' => $this->getRequestType(),
            'message_type' => $this->getMessageType(),
            'mobile' => $this->getRecipient(),
            'message_body' => $this->getMessageBody()
        ];

        if ($this->getRequestType() == 'campaign') {
            if ($campaignTitle == null) {
                throw new \Exception('Campaign Title is required for bulk campaign');
            }
            $data['campaign_title'] = $this->getCampaignTitle();
        }
        return $this->callToApi($data);
    }

    /**
     * Send same sms to multiple recipient
     *
     * @param $message
     * @param $recipient
     * @param $messageType
     * @param $campaignTitle
     * @return mixed|string
     * @throws \Exception
     */
    public function sendBulkSms($message, $recipient, $messageType, $campaignTitle)
    {
        $this->setApiUrl($this->config['apiUrl']['send_sms']);
        $this->setRequestType('campaign');
        $this->setMessageBody($message);
        $this->setRecipient($recipient);
        $this->setMessageType($messageType);
        $this->setCampaignTitle($campaignTitle);

        $data = [
            'api_key' => $this->getApiKey(),
            'api_secret' => $this->getApiSecret(),
            'request_type' => $this->getRequestType(),
            'message_type' => $this->getMessageType(),
            'mobile' => $this->getRecipient(),
            'message_body' => $this->getMessageBody()
        ];

        if ($campaignTitle == null) {
            throw new \Exception('Campaign Title is required for bulk campaign');
        }
        $data['campaign_title'] = $this->getCampaignTitle();

        return $this->callToApi($data);
    }

    /**
     * Send quick campaign message. Different sms to different recipients.
     *
     * @param $smsArray
     * @param $messageType
     * @param null $campaignTitle
     * @return mixed|string
     * @throws \Exception
     */
    public function quickCampaign($smsArray, $messageType, $campaignTitle = null)
    {
        $this->setApiUrl($this->config['apiUrl']['send_sms']);
        $this->setRequestType('quick_campaign');
        $this->setMessageType($messageType);
        $this->setCampaignTitle($campaignTitle);

        $data = [
            'api_key' => $this->getApiKey(),
            'api_secret' => $this->getApiSecret(),
            'request_type' => $this->getRequestType(),
            'message_type' => $this->getMessageType(),
        ];

        if ($campaignTitle != null) {
            $data['campaign_title'] = $this->getCampaignTitle();
        }

        foreach ($smsArray as $key => $sms) {
            if (!(isset($sms['mobile']) && isset($sms['message_body']))) {
                throw new \Exception('SMS Array format is not correct.');
            }
            $data["sms[$key][mobile]"] = $sms['mobile'];
            $data["sms[$key][message_body]"] = $sms['message_body'];
        }

        return $this->callToApi($data);
    }

    /**
     * Check campaign message status
     *
     * @param $campaignUid
     * @return mixed|string
     */
    public function checkCampaignStatus($campaignUid)
    {
        $this->setApiUrl($this->config['apiUrl']['check_campaign_status']);

        $data = [
            'api_key' => $this->getApiKey(),
            'api_secret' => $this->getApiSecret(),
            'campaign_uid' => $campaignUid
        ];

        return $this->callToApi($data);
    }

    /**
     * Check a single sms status
     *
     * @param $smsUid
     * @return mixed|string
     */
    public function checkSmsStatus($smsUid)
    {
        $this->setApiUrl($this->config['apiUrl']['check_sms_status']);

        $data = [
            'api_key' => $this->getApiKey(),
            'api_secret' => $this->getApiSecret(),
            'sms_uid' => $smsUid
        ];

        return $this->callToApi($data);
    }
}
