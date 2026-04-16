<?php
/**
 * Webhook Registration Script for SMS Gateway (Cloud Mode)
 * This script registers your server to receive status updates.
 */

require_once 'app/Core/Database.php';
require_once 'app/Models/Setting.php';

use App\Models\Setting;

echo "<h2>SMS Gateway Webhook Setup</h2>";

// 1. Get Credentials
$settingModel = new Setting();
$settings = $settingModel->getAll();

$username = $settings['api_username'] ?? '';
$password = $settings['api_password'] ?? '';
$baseUrl = 'https://kitnime.site/public'; // Change if needed
$webhookUrl = $baseUrl . '/api/webhook';

if (empty($username) || empty($password)) {
    die("<b style='color:red'>ERROR: API credentials not found in settings. Please configure them first in the Dashboard.</b>");
}

$events = ['sms:sent', 'sms:delivered', 'sms:failed'];
$results = [];

echo "Registering Webhook for: <code>$webhookUrl</code><br><br>";

foreach ($events as $event) {
    $payload = [
        'url' => $webhookUrl,
        'event' => $event
    ];

    $ch = curl_init('https://api.sms-gate.app/3rdparty/v1/webhooks');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode("$username:$password")
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $results[$event] = [
        'code' => $httpCode,
        'response' => json_decode($response, true)
    ];
}

// 3. Display Results
echo "<table border='1' cellpadding='10' style='border-collapse:collapse; width:100%;'>";
echo "<tr style='background:#eee;'><th>Event</th><th>Status Code</th><th>Result</th></tr>";

foreach ($results as $event => $res) {
    $color = ($res['code'] >= 200 && $res['code'] < 300) ? 'green' : 'red';
    $statusText = ($res['code'] >= 200 && $res['code'] < 300) ? 'SUCCESS' : 'FAILED';
    
    echo "<tr>";
    echo "<td>$event</td>";
    echo "<td style='color:$color; font-weight:bold;'>{$res['code']} ($statusText)</td>";
    echo "<td><pre>" . json_encode($res['response'], JSON_PRETTY_PRINT) . "</pre></td>";
    echo "</tr>";
}
echo "</table>";

echo "<br><p><b>Note:</b> If it says 'SUCCESS', your phone will now start sending status updates to your dashboard.</p>";
echo "<a href='/public/logs' style='padding:10px 20px; background:#4F46E5; color:white; text-decoration:none; border-radius:5px;'>Back to Logs</a>";
