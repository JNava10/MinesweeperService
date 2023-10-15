<?php

namespace routes;

use Constants;
use factory\GameFactory;


class PlayRoute {
    public static function handleRequest(array $requestArgs, ?array $requestBody, string $requestMethod): bool|string {
        return match ($requestMethod) {
            Constants::POST => self::handlePostRequest($requestArgs, $requestBody),
        };
    }

    private static function handlePostRequest(array $requestArgs, ?array $requestBody): bool|string {
        $response = [];
        $response['game'][] = GameFactory::createDefaultGame();;

        return json_encode($response);
    }
}