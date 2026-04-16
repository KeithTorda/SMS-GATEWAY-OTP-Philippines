<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class ApiKey {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM api_keys ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name) {
        $key = bin2hex(random_bytes(24));
        $stmt = $this->db->prepare("INSERT INTO api_keys (name, key_value) VALUES (?, ?)");
        if ($stmt->execute([$name, $key])) {
            return $key;
        }
        return false;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM api_keys WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function isValid($key) {
        $stmt = $this->db->prepare("SELECT id FROM api_keys WHERE key_value = ?");
        $stmt->execute([$key]);
        $apiKey = $stmt->fetch();

        if ($apiKey) {
            // Update last used timestamp
            $this->updateLastUsed($apiKey['id']);
            return true;
        }

        return false;
    }

    protected function updateLastUsed($id) {
        $stmt = $this->db->prepare("UPDATE api_keys SET last_used_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$id]);
    }
}
