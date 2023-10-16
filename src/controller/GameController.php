<?php

namespace controller;

use factory\GameFactory;

class GameController {
    public static function createDefaultGame($userId): bool {
        return Database::insertRow(\Constants::GAMES_TABLE, GameFactory::createDefaultGame($userId));
    }
}