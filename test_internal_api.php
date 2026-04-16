<?php
/**
 * Internal API Connection Test
 * This script tests the local /api/send endpoint using your generated API Key.
 */

// --- CONFIGURATION ---
// 1. Generate an API Key in Settings > API Integrations
// 2. Paste it here:
$yourApiKey = 'PASTE_YOUR_GENERATED_KEY_HERE'; 

// 3. Local test phone number
$testPhone = '09290000000'; // Change to your number for testing

// 4. Base URL detection
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$apiUrl = $protocol . "://" . $host . $basePath . "/public/api/send";

// --- EXECUTION ---
echo "<h2>Internal API Tester</h2>";
echo "Testing Endpoint: <code>$apiUrl</code><br><br>";

if ($yourApiKey === 'PASTE_YOUR_GENERATED_KEY_HERE') {
    echo "<b style='color:red'>ERROR: Please paste your generated API Key in the script!</b>";
    exit;
}

$payload = [
    'phone_number' => $testPhone,
    'message' => 'OTP Test: ' . rand(100000, 999999),
    'sender_name' => 'TestSystem'
];

echo "<b>Sending Payload (JSON):</b><br>";
echo "<pre>" . json_encode($payload, JSON_PRETTY_PRINT) . "</pre>";

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-API-KEY: ' . $yourApiKey
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo "<b style='color:red'>CURL Error:</b> " . curl_error($ch);
} else {
    echo "<b>HTTP Status Code:</b> $httpCode<br>";
    echo "<b>Response:</b><br>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
    
    $data = json_decode($response, true);
    if ($httpCode >= 200 && $httpCode < 300) {
        echo "<b style='color:green'>SUCCESS!</b> API call was successful.";
    } else {
        echo "<b style='color:red'>FAILED.</b> Check your API key and server logs.";
    }
}

curl_close($ch);
?>
