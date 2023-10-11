<?php

namespace controller;

use Constants;

class GameController {

    private static $responseStatus = [];

    static function createGame($requestArgs, $requestBody) {
        $table = Factory::buildHiddenTable($requestArgs[1], $requestArgs[2]);

        //TODO: Database::insertGame($table...);

        if (!empty($requestArgs)) {
            // TODO: responseStatus = Factory::createError(400);
        } else {
            $table = Factory::buildHiddenTable(Constants::DEFAULT_TABLE_LENGTH, Constants::DEFAULT_MINE_QUANTITY);
            // TODO: Database::insertGame($table...);
        }
    }

    static function updateGame(array $requestBody) {
        $gameStarted = $requestBody['gameStarted'];
        $positionClicked = $requestBody['positionClicked'];

        if (!$gameStarted) {
            // TODO: $responseStatus = Factory::createErrorStatus(400);
        } else {
            self::handlePlayerActions($positionClicked);
            // TODO: $responseStatus = Factory::createSuccessStatus(200);
        }
    }

    private static function handlePlayerActions($positionClicked) {

    }
}