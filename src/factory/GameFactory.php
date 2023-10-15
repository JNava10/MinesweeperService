<?php

namespace factory;

use Constants;

class GameFactory {
    public static function createGame(int $boxes, int $mines): array {
        $gameBoxes = array_fill(0, $boxes, 0);

        $gameBoxes = self::placeMines($gameBoxes, $mines);
        return self::placeAdjacentNumbers($gameBoxes);
    }

    public static function createDefaultGame(): array {
        return self::createGame(Constants::DEFAULT_BOXES, Constants::DEFAULT_MINES);
    }

    private static function placeMines(array $gameBoxes, int $mines): array {

        for ($i = 0; $i < $mines; $i++) {
            if ($gameBoxes[rand(0, count($gameBoxes) - 1)] !== Constants::MINE) {
                $gameBoxes[rand(0, count($gameBoxes) - 1)] = Constants::MINE;
            }
        }

        return $gameBoxes;
    }

    private static function placeAdjacentNumbers(array $gameBoxes): array {

        for ($i = 0; $i < count($gameBoxes); $i++) {
            if (
                $gameBoxes[$i + 1] === Constants::MINE && isset($gameBoxes[$i + 1]) ||
                $gameBoxes[$i - 1] === Constants::MINE && isset($gameBoxes[$i - 1])
            ) {
                $gameBoxes[$i] = 1;
            } elseif (
                $gameBoxes[$i + 1] === Constants::MINE && isset($gameBoxes[$i + 1]) &&
                $gameBoxes[$i - 1] === Constants::MINE && isset($gameBoxes[$i - 1])
            ) {
                $gameBoxes[$i] = 2;
            }
        }

        return $gameBoxes;
    }
}