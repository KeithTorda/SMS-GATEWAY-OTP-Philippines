<?php
/**
 * Detailed API Test Script
 * Use this to see the raw communication with the SMS Gateway.
 */

require_once 'app/Core/Database.php';
require_once 'app/Models/Setting.php';

use App\Models\Setting;

echo "<h2>SMS Gateway Debugger</h2>";

// 1. Get Credentials
$settingModel = new Setting();
$settings = $settingModel->getAll();

$username = $settings['api_username'] ?? '';
$password = $settings['api_password'] ?? '';

if (empty($username) || empty($password)) {
    die("ERROR: No API credentials found in settings.");
}

// 2. Test Configuration
$testNumber = "09123456789"; // Change this to your test number
$testMessage = "Debug Test - " . date('H:i:s');

echo "Sending test message to $testNumber...<br>";

// 3. Prepare Payload (Official v1 Structure)
$payload = [
    'phoneNumbers' => [$testNumber],
    'textMessage' => [
        'text' => $testMessage
    ]
];

// 4. Execute cURL
$ch = curl_init('https://api.sms-gate.app/3rdparty/v1/messages?skipPhoneValidation=true');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode("$username:$password")
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// 5. Report
echo "<h3>Results:</h3>";
echo "<b>HTTP Status Code:</b> $httpCode<br>";

if ($curlError) {
    echo "<b style='color:red'>cURL Error:</b> $curlError<br>";
}

echo "<b>Raw Response:</b><br>";
echo "<pre style='background:#f4f4f4; p-4; border:1px solid #ccc;'>" . htmlspecialchars($response) . "</pre>";

$json = json_decode($response, true);
if ($json) {
    echo "<b>Decoded JSON:</b><br>";
    echo "<pre>" . json_encode($json, JSON_PRETTY_PRINT) . "</pre>";
} else {
    echo "<b style='color:orange'>Warning:</b> Response is not valid JSON.<br>";
}

echo "<hr>";
echo "<p>If the Raw Response shows an <b>'id'</b>, it means the message was successfully sent to the cloud. If it never arrives at the phone, check your signal or app logs on the Android device.</p>";
