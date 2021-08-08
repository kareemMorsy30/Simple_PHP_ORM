<?php
require_once 'vendor/autoload.php';
use Routes\Router;
use App\Controllers\CustomerController;

$project_base = basename(__DIR__);

Router::route('/', function() {
    header("Location: http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['project_base']."/customers");
});

Router::route('/customers', [
    CustomerController::class,
    'index'
]);

Router::route('/about', function() {
    echo 'Jumia market';
});

$action = $_SERVER['REQUEST_URI'];
Router::dispatch($action);
exit();