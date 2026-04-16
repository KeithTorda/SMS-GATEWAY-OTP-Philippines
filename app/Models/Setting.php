<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Setting {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT key_name, key_value FROM settings");
        $stmt->execute();
        $results = $stmt->fetchAll();
        
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['key_name']] = $row['key_value'];
        }
        return $settings;
    }

    public function update($key, $value) {
        $stmt = $this->db->prepare("UPDATE settings SET key_value = ? WHERE key_name = ?");
        return $stmt->execute([$value, $key]);
    }
}
