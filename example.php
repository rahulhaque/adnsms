<?php

require 'src/AdnSms.php';

use AdnSms\AdnSms;

$message = "This is a test message.";
$recipient="01XXXXXXXXX"; // Number to send message
$requestType = 'single_sms'; // Request sms type: "single_sms" or "OTP"
$messageType = 'Text'; // Message content type: "Text" or "Unicode"

// api_key and api_secret are provided by adn sms
$AdnSms = new AdnSms('api_key','api_secret');
$result = $AdnSms->sendSms($requestType, $message, $recipient, $messageType);

print_r($result);

?>