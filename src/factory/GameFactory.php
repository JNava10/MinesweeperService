<?php

namespace factory;

use Constants;
use model\Game;

class GameFactory {
    public static function createGame(int $boxes, int $mines, int $userId): Game {
        $hiddenTable = array_fill(0, $boxes, 0);
        $hiddenTable = self::placeMines($hiddenTable, $mines);

        return new Game(
            $userId,
            self::createProgressTable($boxes),
            self::placeAdjacentNumbers($hiddenTable),
            false
        );
    }

    public static function createDefaultGame(int $userId): Game {
        return self::createGame(Constants::DEFAULT_BOXES, Constants::DEFAULT_MINES, $userId);
    }

    private static function placeMines(array $gameBoxes, int $mines): array {

        for ($i = 0; $i < $mines; $i++) {
            $minePosition = rand(0, count($gameBoxes) - 1);

            if ($gameBoxes[$minePosition] !== Constants::MINE) {
                $gameBoxes[$minePosition] = Constants::MINE;

                echo $minePosition;
            }
        }

        return $gameBoxes;
    }

    private static function placeAdjacentNumbers(array $gameBoxes): array {

        for ($i = 0; $i < count($gameBoxes); $i++) {
            if (
                $gameBoxes[$i] !== Constants::MINE && (
                    isset($gameBoxes[$i + 1]) && $gameBoxes[$i + 1] === Constants::MINE ||
                    isset($gameBoxes[$i - 1]) && $gameBoxes[$i - 1] === Constants::MINE
                )
            ) {
                $gameBoxes[$i] = 1;
            } elseif (
                $gameBoxes[$i] !== Constants::MINE && (
                    isset($gameBoxes[$i + 1]) && $gameBoxes[$i + 1] === Constants::MINE &&
                    isset($gameBoxes[$i - 1]) && $gameBoxes[$i - 1] === Constants::MINE
                )
            ) {
                $gameBoxes[$i] = 2;
            }
        }

        return $gameBoxes;
    }

    public static function createProgressTable(int $gameBoxes) {
        return array_fill(0, $gameBoxes - 1, Constants::HIDDEN);
    }
}