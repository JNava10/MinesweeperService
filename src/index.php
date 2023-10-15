<?php
use routes\PlayRoute;

require_once __DIR__ . "/routes/PlayRoute.php";
require_once __DIR__ . '/Constants.php';
require_once __DIR__ . '/factory/GameFactory.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestArgs = explode('/', $_SERVER['REQUEST_URI']);
$requestBody = json_decode(file_get_contents('php://input'), true);

unset($requestArgs[0]);
header("Content-Type:application/json");

echo match ($requestArgs[1]) {
    "play" => PlayRoute::handleRequest(
        $requestArgs,
        $requestBody,
        $requestMethod
    )
};