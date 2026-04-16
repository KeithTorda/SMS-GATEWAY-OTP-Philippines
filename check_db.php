<?php
/**
 * Database Status Check
 * Use this to verify your Hostinger DB connection and schema.
 */

require_once 'app/Core/Database.php';

use App\Core\Database;

echo "<h2>Database Connection & Schema Check</h2>";

try {
    $db = Database::getInstance()->getConnection();
    echo "<p style='color:green'>✔ Connected successfully to the database.</p>";
    
    // Check for sms_logs table and its columns
    $stmt = $db->query("DESCRIBE sms_logs");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Table: sms_logs</h3>";
    echo "<table border='1' cellpadding='5' style='border-collapse:collapse;'>";
    echo "<tr style='background:#eee;'><th>Column</th><th>Type</th></tr>";
    
    $foundGatewayId = false;
    foreach ($columns as $col) {
        $name = $col['Field'];
        $type = $col['Type'];
        $style = "";
        
        if ($name === 'gateway_id') {
            $foundGatewayId = true;
            $style = "background: #d1fae5; font-weight: bold;";
        }
        
        echo "<tr style='$style'><td>$name</td><td>$type</td></tr>";
    }
    echo "</table>";
    
    if ($foundGatewayId) {
        echo "<p style='color:green; font-weight:bold;'>✔ SUCCESS: 'gateway_id' column found. Everything is ready!</p>";
    } else {
        echo "<p style='color:red; font-weight:bold;'>✖ ERROR: 'gateway_id' column is MISSING.</p>";
        echo "<p>Please run the SQL command in your phpMyAdmin to add the missing columns.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>✖ CONNECTION FAILED: " . $e->getMessage() . "</p>";
}

echo "<br><a href='/public/'>Back to Dashboard</a>";
