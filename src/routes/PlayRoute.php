<?php

namespace routes;

use Constants;
use controller\GameController;
use factory\GameFactory;


class PlayRoute {
    public static function handleRequest(array $requestArgs, ?array $requestBody, string $requestMethod): bool|string {
        return match ($requestMethod) {
            Constants::POST => self::handlePostRequest($requestArgs, $requestBody),
        };
    }

    private static function handlePostRequest(array $args, ?array $body): bool|string {
        $response = [];

        if (!$args[3]) {
            $response['game'] = GameController::createDefaultGame();
        } else {
            $response['game'] = GameFactory::createGame($args[3], $args[4]);
        }

        return json_encode($response);
    }
}