<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Standard MVC Autoloader
spl_autoload_register(function ($class) {
    // Alisin ang App\ at gawing direct path papunta sa ../app/
    $classPath = str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';
    $file = __DIR__ . '/../app/' . $classPath;
    
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Fallback for case-sensitive Linux hostings
        $fileLower = __DIR__ . '/../app/' . strtolower($classPath);
        if (file_exists($fileLower)) {
            require_once $fileLower;
        }
    }
});

// Load environment variables
\App\Core\Env::load(__DIR__ . '/../.env');

use App\Core\Router;

try {
    $router = new Router();
    
    // Define Routes
    $router->add('GET', '/', 'DashboardController@index');
    $router->add('GET', '/logs', 'LogController@index');
    $router->add('GET', '/settings', 'SettingsController@index');
    $router->add('POST', '/send', 'SMSController@send');
    $router->add('POST', '/settings/update', 'SettingsController@update');
    $router->add('POST', '/settings/api-keys/generate', 'SettingsController@generateApiKey');
    $router->add('POST', '/settings/api-keys/delete', 'SettingsController@deleteApiKey');
    $router->add('POST', '/api/send', 'ApiController@send');
    $router->add('POST', '/api/webhook', 'ApiController@webhook');

    $router->handle();
    
} catch (Throwable $e) {
    echo "<h1>MVC Core Error</h1>";
    echo "<p>" . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . "</p>";
}
