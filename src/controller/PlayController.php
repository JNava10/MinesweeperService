<?php

namespace controller;

use Constants;
use factory\GameTableFactory;
use model\Game;

class PlayController {
    public static function createGame(int $boxes, int $mines, int $userId): Game | bool {
        $game = self::createHiddenTable($boxes, $mines, $userId);
        Database::insertGame($game);
        $game->setGameId(Database::selectLastGameId() + 1);

        return $game;
    }

    public static function getGame(int $id): array{
        return Database::selectGame($id);
    }

    public static function getGameUser(int $gameId) {
        return Database::selectGameUser($gameId);
    }

    public static function updateGame(string $userEmail, string $userPassword, int $gameBox) {
        $response = null;

        echo Database::selectUserId($userEmail, $userPassword);
        $activeGamesList = Database::selectUserGames($userEmail, true);

        if (!$activeGamesList) {
            $response = false;
        } elseif (count($activeGamesList) === 1) {
            $game = $activeGamesList[0];

            $response = self::updateGameProgress($game, $gameBox);
        }

        return $response;
    }

    private static function updateGameProgress(Game $game, int $gameBox): bool | int {
        $hiddenBox = $game->getHidden()[$gameBox];

        $game->setProgressGameBox($hiddenBox, $gameBox);

        if ($hiddenBox === Constants::MINE) {
            $game->setFinished(-1);
        } elseif (!array_search(Constants::HIDDEN,  $game->getProgress())) {
            $game->setFinished(1);
        }

        if (Database::updateGameProgress($game)) {
            return $game->getFinished();
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

    public static function createProgressTable(int $gameBoxes): array {
        return array_fill(0, $gameBoxes, Constants::HIDDEN);
    }

    public static function getUserOpenedGames(int $id): array {
        return Database::selectUserGames($id, false);
    }

    public static function checkIfEmailExists(string $email) {
        return Database::checkIfEmailExists($email);
    }

    public static function getGameIdList(): array {
        return Database::selectAllGameIds();
    }
}