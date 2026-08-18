<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'app/config/config.php';
require 'app/Core/Database.php';
require 'app/Core/Model.php';
require 'app/Models/Payment.php';
require 'app/Models/User.php';
require 'app/Core/Request.php';
require 'app/Core/Response.php';
require 'app/Core/Session.php';
require 'app/Core/Controller.php';
require 'app/Controllers/AdminController.php';
require 'app/Controllers/ProjectController.php';

try {
    // We need to bypass checkPermission which calls has_permission
    if (!function_exists('has_permission')) {
        function has_permission($p) { return true; }
    }
    if (!function_exists('url')) {
        function url($p) { return $p; }
    }
    if (!function_exists('e')) {
        function e($p) { return $p; }
    }
    require 'app/Core/View.php'; // ensure view works if it exists
    
    $c = new \App\Controllers\ProjectController();
    echo $c->index(new \App\Core\Request(), new \App\Core\Response());
} catch (\Throwable $e) {
    echo "ERROR CATCHED: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine();
}
