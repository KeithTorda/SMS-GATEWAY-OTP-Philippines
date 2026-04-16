<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\SMSLog;
use App\Models\Setting;

class SMSController extends Controller {
    public function send() {
        $phoneNumber = $_POST['phone_number'] ?? '';
        $message = $_POST['message'] ?? '';
        $senderName = $_POST['sender_name'] ?? '';
        $simSlot = $_POST['sim_slot'] ?? null;

        // Normalize phone number (handle 09XXXXXXXXX format)
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);
        if (str_starts_with($phoneNumber, '09') && strlen($phoneNumber) === 11) {
            $phoneNumber = '+63' . substr($phoneNumber, 1);
        }

        if (empty($phoneNumber) || empty($message)) {
            return $this->json(['error' => 'Phone number and message are required.'], 400);
        }

        // Prepend Sender Name if provided
        $finalMessage = !empty($senderName) ? "[{$senderName}]: {$message}" : $message;

        $settingModel = new Setting();
        $settings = $settingModel->getAll();

        $username = $settings['api_username'] ?? '';
        $password = $settings['api_password'] ?? '';
        $deviceId = $settings['device_id'] ?? '';

        if (empty($username) || empty($password) || empty($deviceId)) {
            return $this->json(['error' => 'API credentials are not configured.'], 400);
        }

        $payload = [
            'textMessage' => [
                'text' => $finalMessage
            ],
            'phoneNumbers' => [$phoneNumber],
            'deviceId' => $deviceId,
            'priority' => 127 // High priority for instant sending
        ];

        // Add SIM slot if specified
        if ($simSlot !== null && $simSlot !== '') {
            $payload['simNumber'] = (int)$simSlot;
        }

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
        curl_close($ch);

        $responseData = json_decode($response, true);
        $status = ($httpCode >= 200 && $httpCode < 300) ? 'Sent' : 'Failed';
        $gatewayId = $responseData['id'] ?? null;

        try {
            // Log the message
            $logModel = new SMSLog();
            $logModel->create([
                'sender_name' => $senderName,
                'sim_slot' => $simSlot,
                'phone_number' => $phoneNumber,
                'message' => $finalMessage,
                'status' => $status,
                'api_response' => $response,
                'gateway_id' => $gatewayId
            ]);
        } catch (\Exception $e) {
            // If DB logging fails, we still want to tell the user if the SMS was actually sent
            return $this->json([
                'status' => $status,
                'warning' => 'Message sent but failed to log to database: ' . $e->getMessage(),
                'response' => $responseData,
                'message_id' => $gatewayId
            ], 200); // Return 200 so the frontend doesn't show "Network Error"
        }

        return $this->json([
            'status' => $status,
            'response' => $responseData,
            'message_id' => $gatewayId
        ], $httpCode > 0 ? $httpCode : 500);
    }
}
