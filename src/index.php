<?php

use model\Status;
use routes\AdminRoute;
use routes\PlayRoute;

require_once __DIR__ . "/routes/AdminRoute.php";
require_once __DIR__ . "/routes/PlayRoute.php";
require_once __DIR__ . "/routes/LoginRoute.php";
require_once __DIR__ . '/Constants.php';
require_once __DIR__ . '/model/Status.php';
require_once __DIR__ . '/model/User.php';
require_once __DIR__ . '/model/Game.php';
require_once __DIR__ . '/controller/Database.php';
require_once __DIR__ . '/controller/AdminController.php';
require_once __DIR__ . '/controller/LoginController.php';
require_once __DIR__ . '/controller/PlayController.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestArgs = explode('/', $_SERVER['REQUEST_URI']);
$requestBody = json_decode(file_get_contents('php://input'), true);

unset($requestArgs[0]);
header("Content-Type:application/json");

echo match ($requestArgs[1]) {
    "admin" => AdminRoute::handleRequest(
        $requestArgs,
        $requestBody,
        $requestMethod
    ),

    "play" => PlayRoute::handleRequest(
        $requestArgs,
        $requestBody,
        $requestMethod
    ),

    "login" => LoginRoute::handleRequest(
        $requestBody,
        $requestMethod
    ),

    default => json_encode(new Status(404, Constants::RESPONSES[404]))
};