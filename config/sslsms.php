<?php

/*
|--------------------------------------------------------------------------
| SSL Wireless SMS (iSMS / SMS Plus) configuration
|--------------------------------------------------------------------------
|
| Credentials and endpoint for the SSL Wireless SMS gateway used to deliver
| OTP messages. Values come from the SSL Wireless merchant panel.
|
*/

return [
    // API token provided by SSL Wireless.
    'api_token' => env('SSLSMS_API_TOKEN'),

    // Sender/Service ID (SID) provided by SSL Wireless.
    'sid' => env('SSLSMS_SID'),

    // API domain, e.g. https://smsplus.sslwireless.com
    'domain' => env('SSLSMS_DOMAIN', 'https://smsplus.sslwireless.com'),

    // Whether to verify the gateway's SSL certificate. The vendor sample ships
    // with peer verification disabled; keep it configurable for production.
    'verify_ssl' => env('SSLSMS_VERIFY_SSL', false),
];
