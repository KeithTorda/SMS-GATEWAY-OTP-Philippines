<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\SMSLog;
use App\Models\Setting;

class ApiController extends Controller {
    public function send() {
        // 1. Verify API Key
        if (!$this->verifyApiKey()) {
            return $this->json(['error' => 'Unauthorized: Invalid or missing API Key (X-API-KEY header required)'], 401);
        }

        // 2. Capture and Normalize Request Data
        $input = $_POST;
        
        // Handle JSON payload
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            if (is_array($data)) {
                $input = array_merge($input, $data);
            }
        }

        $phoneNumber = $input['phone_number'] ?? '';
        $message = $input['message'] ?? '';
        $senderName = $input['sender_name'] ?? '';
        $simSlot = $input['sim_slot'] ?? null;

        // Normalize phone number
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);
        if (str_starts_with($phoneNumber, '09') && strlen($phoneNumber) === 11) {
            $phoneNumber = '+63' . substr($phoneNumber, 1);
        }

        if (empty($phoneNumber) || empty($message)) {
            return $this->json(['error' => 'Phone number and message are required.'], 400);
        }

        // 3. Prepare Message
        $finalMessage = !empty($senderName) ? "[{$senderName}]: {$message}" : $message;

        // 4. Get API Credentials
        $settingModel = new Setting();
        $settings = $settingModel->getAll();

        $username = $settings['api_username'] ?? '';
        $password = $settings['api_password'] ?? '';
        $deviceId = $settings['device_id'] ?? '';

        if (empty($username) || empty($password) || empty($deviceId)) {
            return $this->json(['error' => 'API Gateway credentials are not configured in settings.'], 500);
        }

        // 5. Send to Android SMS Gateway
        $payload = [
            'textMessage' => [
                'text' => $finalMessage
            ],
            'phoneNumbers' => [$phoneNumber],
            'deviceId' => $deviceId,
            'priority' => 127
        ];

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
            // 6. Log the message
            $logModel = new SMSLog();
            $logModel->create([
                'sender_name' => $senderName . ' (via API)',
                'sim_slot' => $simSlot,
                'phone_number' => $phoneNumber,
                'message' => $finalMessage,
                'status' => $status,
                'api_response' => $response,
                'gateway_id' => $gatewayId
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'status' => $status,
                'warning' => 'API send success but DB logging failed: ' . $e->getMessage(),
                'gateway_id' => $gatewayId,
                'api_response' => $responseData
            ], 200);
        }

        return $this->json([
            'status' => $status,
            'message_id' => $gatewayId,
            'api_response' => $responseData
        ], $httpCode);
    }

    public function webhook() {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Ang sms-gate.app payload ay may "event" at "payload" (kung saan nandoon ang "messageId")
        if (!$data || !isset($data['payload']['messageId'])) {
            return $this->json(['error' => 'Invalid payload or missing messageId inside payload'], 400);
        }

        $gatewayId = $data['payload']['messageId'];
        $event = $data['event'] ?? '';
        $status = 'Pending';
        $deliveredAt = null;
        $failedReason = null;

        $payload = $data['payload'];

        switch ($event) {
            case 'sms:sent':
                $status = 'Sent (by Phone)';
                break;
            case 'sms:delivered':
                $status = 'Delivered';
                // Timestamp from payload if available
                $deliveredAt = $payload['deliveredAt'] ?? date('Y-m-d H:i:s');
                break;
            case 'sms:failed':
                $status = 'Failed (at Phone)';
                $failedReason = $payload['reason'] ?? 'Unknown error';
                break;
            default:
                $status = 'Updated (' . $event . ')';
        }

        $logModel = new SMSLog();
        $updated = $logModel->updateStatusByGatewayId($gatewayId, $status, $deliveredAt, $failedReason);

        return $this->json([
            'success' => $updated,
            'gateway_id' => $gatewayId,
            'new_status' => $status,
            'received_event' => $event
        ]);
    }
}
