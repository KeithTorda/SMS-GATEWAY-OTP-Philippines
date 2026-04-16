<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class SMSLog {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO sms_logs (sender_name, sim_slot, phone_number, message, status, api_response, gateway_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['sender_name'] ?? null,
            $data['sim_slot'] ?? null,
            $data['phone_number'],
            $data['message'],
            $data['status'],
            $data['api_response'],
            $data['gateway_id'] ?? null
        ]);
    }

    public function updateStatusByGatewayId($gatewayId, $status, $deliveredAt = null, $failedReason = null) {
        $sql = "UPDATE sms_logs SET status = ?";
        $params = [$status];

        if ($deliveredAt) {
            $sql .= ", delivered_at = ?";
            $params[] = $deliveredAt;
        }

        if ($failedReason) {
            $sql .= ", failed_reason = ?";
            $params[] = $failedReason;
        }

        $sql .= " WHERE gateway_id = ?";
        $params[] = $gatewayId;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM sms_logs ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
