# AdnSms Sms Api Wrapper for PHP / Laravel
A simple php wrapper for adnsms message sending api. Supports Laravel.

## Usage
- Clone the repository.
- Require the class and create instance to access its functions.
- Or install with `composer require adnsms/adnsms`

## Example
A simple single sms send example.
```php
<?php

require 'src/AdnSms.php';
use AdnSms\AdnSms;

$message = "This is a test message.";
$recipient = "01XXXXXXXXX"; // Number to send message
$requestType = 'single_sms'; // Request sms type: "single_sms" or "OTP"
$messageType = 'Text'; // Message content type: "Text" or "Unicode"

// api_key and api_secret are provided by adn sms
$AdnSms = new AdnSms('api_key','api_secret');
$result = $AdnSms->sendSms($requestType, $message, $recipient, $messageType);

print_r($result);

?>
```

## Laravel
- Install with `composer require adnsms/adnsms`
```php
<?php

use AdnSms\AdnSms; // Use the installed package

class SomeController extends Controller
{
    public function someFunction()
    {
        $message = "This is a test message.";
        $recipient = "01XXXXXXXXX"; // Number to send message
        $requestType = 'single_sms'; // Request sms type: "single_sms" or "OTP"
        $messageType = 'Text'; // Message content type: "Text" or "Unicode"
        
        // api_key and api_secret are provided by adn sms
        $AdnSms = new AdnSms('api_key','api_secret');
        $result = $AdnSms->sendSms($requestType, $message, $recipient, $messageType);

        dd($result);
    }
}

?>
```

## Output
Success output for above example.
```javascript
{				
  "request_type": "single_sms",
  "campaign_uid": "CXXXXXXXXXXXXXXXX",
  "sms_uid": "SXXXXXXXXXXXXXXXX",
  "invalid_numbers": [],
  "api_response_code": 200,
  "api_response_message": "SUCCESS" 
}
```

## More Info
You can find a full documentation with more details in `docs` folder. 
