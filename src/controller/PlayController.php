<?php

namespace controller;

use Constants;
use factory\GameTableFactory;
use model\Game;

class PlayController {
    public static function createGame(int $boxes, int $mines, int $userId): Game | bool {
        $game = self::createHiddenTable($boxes, $mines, $userId);
        Database::insertGame($game);
        $game->setGameId(Database::selectLastGameId());

        return $game;
    }

    public static function getGame(int $id): Game {
        return Database::selectGame($id);
    }

    public static function getGameUser(int $gameId) {
        return Database::selectGameUser($gameId);
    }

    public static function updateGame(int $gameId, int $gameBox) {
        $game = PlayController::getGame($gameId);
        return self::updateGameProgress($game, $gameBox);
    }

    private static function updateGameProgress(Game $game, int $gameBox): Game | bool {
        $hiddenBox = $game->getHidden()[$gameBox];

        $game->setProgressGameBox($hiddenBox, $gameBox);

        if ($hiddenBox === Constants::MINE) {
            $game->setFinished(-1);
        } elseif (self::gameIsWinned($game)) {
            $game->setFinished(1);
        }

        if (Database::updateGame($game)) {
            return $game;
        } else {
            return false;
        }
    }

    public static function createHiddenTable(int $boxes, int $mines, int $userId): Game {
        $hiddenTable = array_fill(0, $boxes, 0);
        $hiddenTable = self::placeMines($hiddenTable, $mines);

        return new Game(
            $userId,
            self::createProgressTable($boxes),
            self::placeAdjacentNumbers($hiddenTable),
            false
        );
    }

    private static function placeMines(array $gameBoxes, int $mines): array {
        $minesPlaced = 0;
        for ($i = 0; $minesPlaced < $mines; $i++) {
            $minePosition = rand(0, count($gameBoxes) - 1);

            while ($gameBoxes[$minePosition] === Constants::MINE) {
                echo $minePosition;
                $minePosition = rand(0, count($gameBoxes) - 1);
            }

            $gameBoxes[$minePosition] = Constants::MINE;

            $minesPlaced++;
        }

        return $gameBoxes;
    }

    private static function placeAdjacentNumbers(array $gameBoxes): array {
        for ($i = 0; $i < count($gameBoxes); $i++) {
        if (
                $gameBoxes[$i] !== Constants::MINE && (
                    isset($gameBoxes[$i + 1]) && $gameBoxes[$i + 1] === Constants::MINE &&
                    isset($gameBoxes[$i - 1]) && $gameBoxes[$i - 1] === Constants::MINE
                )
            ) {
            $gameBoxes[$i] = 2;
        }
        elseif (
                $gameBoxes[$i] !== Constants::MINE && (
                    isset($gameBoxes[$i + 1]) && $gameBoxes[$i + 1] === Constants::MINE ||
                    isset($gameBoxes[$i - 1]) && $gameBoxes[$i - 1] === Constants::MINE
                )
            ) {
                $gameBoxes[$i] = 1;
            }
        }

        return $gameBoxes;
    }

    public static function getUserId(string $email, string $password): int | null {
        return Database::selectUserId($email, $password);
    }

    public static function createProgressTable(int $gameBoxes): array {
        return array_fill(0, $gameBoxes, Constants::HIDDEN);
    }

    public static function getUserGames(int $id, bool $finished): array {
        return Database::selectUserGames($id, $finished);
    }

    public static function checkIfEmailExists(string $email): bool {
        return Database::checkIfEmailExists($email);
    }

    public static function getGameIdList(): array {
        return Database::selectAllGameIds();
    }

    private static function gameIsWinned(Game $game) {
        $winned = true;

        for ($i = 0; $i < $game->getBoxesCount(); $i++) {
            echo $game->getProgress()[$i];
            echo $game->getHidden()[$i];

            if ($game->getProgress()[$i] === Constants::HIDDEN && $game->getHidden()[$i] !== Constants::MINE) {
                $winned = false;
            }
        }

        return $winned;
    }
}