<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\SMSLog;

class LogController extends Controller {
    public function index() {
        $logModel = new SMSLog();
        $logs = $logModel->getAll();

        return $this->view('logs.index', [
            'title' => 'Message Logs',
            'logs' => $logs
        ]);
    }
}
