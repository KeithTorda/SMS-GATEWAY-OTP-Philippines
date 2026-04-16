<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Setting;

class SettingsController extends Controller {
    public function index() {
        $settingModel = new Setting();
        $apiKeyModel = new \App\Models\ApiKey();
        
        $settings = $settingModel->getAll();
        $apiKeys = $apiKeyModel->getAll();

        return $this->view('settings.index', [
            'title' => 'Settings',
            'settings' => $settings,
            'apiKeys' => $apiKeys
        ]);
    }

    public function update() {
        $settingModel = new Setting();
        
        foreach ($_POST as $key => $value) {
            $settingModel->update($key, $value);
        }

        return $this->redirect('/settings');
    }

    public function generateApiKey() {
        $name = $_POST['name'] ?? 'Untitled Key';
        $apiKeyModel = new \App\Models\ApiKey();
        $apiKeyModel->create($name);

        return $this->redirect('/settings');
    }

    public function deleteApiKey() {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $apiKeyModel = new \App\Models\ApiKey();
            $apiKeyModel->delete($id);
        }

        return $this->redirect('/settings');
    }
}
