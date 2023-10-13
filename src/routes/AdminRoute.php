<?php

namespace routes;

use Constants;
use controller\UserController;
use model\Status;

class AdminRoute {
    private const VALID_SUBROUTES = [
        'users'
    ];

    private const VALID_METHODS = [
        Constants::GET,
        Constants::POST,
        Constants::PUT,
        Constants::DELETE
    ];

    public static function handleRequest(array $args, array | null $body, string $method) {
        $response = [];

        if ($error = self::requestIsNotValid($args, $body, $method)) {
            $response = $error;
        } else if ($args[2] === self::VALID_SUBROUTES[0]) {
            $response = self::handleUserRequest($args, $body, $method);
        }

        return json_encode($response);
    }

    private static function requestIsNotValid(array $args, array | null $body, string $method): array {
        $error = [];

        if (!in_array($args[2], self::VALID_SUBROUTES)) {
            $error[] = new Status(400, Constants::RESPONSES[400]);
        }

        if (!in_array($method, self::VALID_METHODS)) {
            $error[] = new Status(405, Constants::RESPONSES[405]);
        }

        return $error;
    }

    private static function handleUserRequest(array $args, ?array $body, string $method) {
        if ($method === Constants::GET && !$args[3]) {
            $response = UserController::getAllUsers();
        } else if ($method === Constants::GET && $args[3]) {
            $response = UserController::getUserByUserName($args[3]);
        } else if ($method === Constants::POST && $args[2] === self::VALID_SUBROUTES[0]) {

        }
    }
}