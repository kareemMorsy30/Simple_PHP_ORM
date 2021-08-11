<?php
require_once 'vendor/autoload.php';
use Routes\Router;
use App\Controllers\CustomerController;

// Determine the project root directory name
$project_base = basename(__DIR__);


// Application routes
Router::route('/', function() {
    header("Location: http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['project_base']."/customers");
});

Router::route('/customers', [
    CustomerController::class, // pass route class controller
    'index'                     // And method to call
]);

Router::route('/about', function() {
    echo 'Jumia market';
});

$action = $_SERVER['REQUEST_URI'];

// Use the dispatcher to check the current action and map its defind controller method or the callback function
Router::dispatch($action);
exit();