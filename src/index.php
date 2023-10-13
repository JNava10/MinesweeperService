<?php

use routes\AdminRoute;

require_once __DIR__ . "/routes/AdminRoute.php";
require_once __DIR__ . '/Constants.php';
require_once __DIR__ . '/model/Status.php';
require_once __DIR__ . '/model/User.php';
require_once __DIR__ . '/controller/Database.php';
require_once __DIR__ . '/controller/UserController.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestArgs = explode('/', $_SERVER['REQUEST_URI']);
$requestBody = json_decode(file_get_contents('php://input'));

unset($requestArgs[0]);
header("Content-Type:application/json");

echo match ($requestArgs[1]) {
    "admin" => AdminRoute::handleRequest(
        $requestArgs,
        $requestBody,
        $requestMethod
    )
};