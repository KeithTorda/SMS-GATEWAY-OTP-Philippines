<?php

namespace App\Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        
        // Use realpath to get an absolute, verified path on the server
        $appDir = dirname(__DIR__);
        $viewFilePath = $appDir . "/Views/" . str_replace('.', '/', $view) . ".php";
        
        // Ensure the view file exists before proceeding
        if (!file_exists($viewFilePath)) {
            throw new \Exception("View file not found: " . $viewFilePath);
        }
        
        // Expose a URL helper to views
        $url = function($path) {
            $base = dirname($_SERVER['SCRIPT_NAME']);
            $base = str_replace('\\', '/', $base);
            $base = rtrim($base, '/');
            return $base . '/' . ltrim($path, '/');
        };

        // Pass the absolute path of the sub-view to the layout
        $viewFile = $viewFilePath;
        require $appDir . "/Views/layout/main.php";
    }

    protected function json($data, $code = 200) {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($data);
    }

    protected function redirect($url) {
        $base = dirname($_SERVER['SCRIPT_NAME']);
        $base = str_replace('\\', '/', $base);
        $base = rtrim($base, '/');
        $fullUrl = $base . '/' . ltrim($url, '/');
        header("Location: " . $fullUrl);
        exit();
    }

    protected function verifyApiKey() {
        $headers = [];
        if (function_exists('getallheaders')) {
            foreach (getallheaders() as $name => $value) {
                $headers[strtolower($name)] = $value;
            }
        } else {
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[strtolower(str_replace('_', '-', substr($name, 5)))] = $value;
                }
            }
        }

        $apiKey = $headers['x-api-key'] ?? $_SERVER['HTTP_X_API_KEY'] ?? null;
        
        if (!$apiKey) {
            return false;
        }

        $apiKeyModel = new \App\Models\ApiKey();
        return $apiKeyModel->isValid($apiKey);
    }
}
