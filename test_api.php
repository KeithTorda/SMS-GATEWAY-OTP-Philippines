<?php
/**
 * Simple API connectivity test for Android SMS Gateway
 * Run this to verify your API Username and Password
 */

$username = 'T_AEQZ'; // Update these
$password = 'Keith082703.123';
$deviceId = 'cBlHGpBsjftWgi9N7j8Rn';
$testPhone = '+639290593625';

$payload = [
    'textMessage' => [
        'text' => 'API Connectivity Test - SMS Gateway Dashboard'
    ],
    'phoneNumbers' => [$testPhone],
    'deviceId' => $deviceId
];

echo "Testing connection to https://api.sms-gate.app/3rdparty/v1/message...\n";

$ch = curl_init('https://api.sms-gate.app/3rdparty/v1/message');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode("$username:$password")
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo "CURL Error: " . curl_error($ch) . "\n";
} else {
    echo "HTTP Status Code: $httpCode\n";
    echo "Response:\n";
    echo $response . "\n";
}

curl_close($ch);
