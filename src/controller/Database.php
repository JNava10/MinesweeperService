<?php

namespace controller;

use Constants;
use Exception;
use model\Game;
use model\Status;
use model\User;
use mysqli;
use mysqli_stmt;

class Database {
    static public function connect(): mysqli | string {
        try {
            $connection = new mysqli(
                \Constants::HOSTNAME,
                \Constants::USERNAME,
                \Constants::PASSWORD,
                \Constants::DATABASE
            );
        } catch (Exception $exception) {
            $connection = $exception->getMessage();
        } finally {
            return $connection;
        }
    }

    public static function insertRow($table, $object): bool {
        return match ($table) {
            Constants::GAMES_TABLE => self::insertGame($object)
        };
    }

    public static function selectUserGames(string $email, bool $active): array | string {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::SELECT_GAMES_BY_USER_EMAIL);
        $statement->bind_param(
            's',
            $userName
        );

        $users = self::fetchGames($statement);
        $connection->close();

        return $users;
    }

    private static function insertGame(Game $game): bool {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::INSERT_GAME);
        $userId = $game->getUserId();
        $progress = $game->getProgress();
        $hidden = $game->getHidden();
        $finished = $game->getFinished();

        $statement->bind_param(
            Constants::GAME_PARAMS,
            $userId,
            $progress,
            $hidden,
            $finished
        );

        try {
            $executed = $statement->execute();
        } catch (Exception $exception) {
            $executed = false;

            echo $exception->getMessage();
        }

        $connection->close();
        
        return $executed;
    }

    private static function fetchGames(bool|mysqli_stmt $statement): array {
        $statement->execute();
        $rows = $statement->get_result();
        $users = [];

        while ($rows->num_rows !== 0 && $row = $rows->fetch_array()) {
            $users[] = new Game(
                $row['userId'],
                $row['progress'],
                $row['hidden'],
                $row['finished']
            );
        }

        $rows->free_result();

        return $users;
    }
}