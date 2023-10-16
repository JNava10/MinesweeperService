<?php

namespace controller;

use Constants;
use Exception;
use model\User;
use mysqli;
use mysqli_stmt;

class Database {

    //TODO: Test this.

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

    public static function selectAllUsers(): array | string {
        try {
            $connection = self::connect();
            $statement = $connection->prepare(Constants::SELECT_ALL_USERS);
            $users = self::fetchUsers($statement);

            $connection->close();

            return $users;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

     public static function selectUserByUserName(string $userName): array {
         $connection = self::connect();
         $statement = $connection->prepare(Constants::SELECT_USER_BY_USERNAME);
         $statement->bind_param(
             's',
             $userName
         );

         $users = self::fetchUsers($statement);
         $connection->close();

         return $users;
    }

    public static function selectUserData(string $email): User | bool {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::SELECT_USER_BY_EMAIL);
        $statement->bind_param(
            's',
            $email
        );

        $statement->execute();
        $rows = $statement->get_result();
        $user = false;

        while ($rows->num_rows !== 0 && $row = $rows->fetch_array()) {
            $user = new User(
                $row['userName'],
                $email,
                null,
                $row['gamesPlayed'],
                $row['gamesWinned'],
                $row['enabled']
            );
        }

        $rows->free_result();
        $connection->close();

        return $user;
    }

    public static function selectUserPassword(string $email): string | bool {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::SELECT_USER_PASSWORD);
        $statement->bind_param(
            's',
            $email
        );

        $statement->execute();
        $rows = $statement->get_result();
        $password = false;

        while ($rows->num_rows !== 0 && $row = $rows->fetch_array()) {
            $password = $row['password'];
        }

        $rows->free_result();
        $connection->close();

        return $password;
    }


    public static function selectUserStatus(string $email) {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::SELECT_USER_ADMIN_DATA);
        $statement->bind_param(
            's',
            $email
        );

        $statement->execute();
        $rows = $statement->get_result();
        $enabled = null;

        while ($rows->num_rows !== 0 && $row = $rows->fetch_array()) {
            $enabled = $row['enabled'];
        }

        $rows->free_result();
        $connection->close();

        return $enabled;
    }

    public static function selectAllEmails() {
        try {
            $connection = self::connect();
            $statement = $connection->prepare(Constants::SELECT_ALL_EMAILS);
            $emails = self::fetchEmails($statement);

            $connection->close();

            return $emails;
        } catch (Exception $exception) {
            return false;
        }
    }

    static public function selectUserByEmail(string $email): array {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::SELECT_USER_BY_EMAIL);
        $statement->bind_param(
            's',
            $email
        );

        $users = self::fetchUsers($statement);
        $connection->close();

        return $users;
    }

     public static function insertUser(User $user): bool {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::INSERT_USER);
        $userName = $user->getUserName();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $gamesPlayed = $user->getGamesPlayed();
        $gamesWinned = $user->getGamesWinned();
        $executed = true;

        $statement->bind_param(
            Constants::USER_PARAMS,
            $userName,
            $email,
            $password,
            $gamesPlayed,
            $gamesWinned
        );

        try {
            $statement->execute();
        } catch (Exception $exception) {
            $executed = false;
        }

        $connection->close();

         return $executed;
    }

    public static function deleteUser(int $id): bool {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::DELETE_USER);

        $statement->bind_param(
            'i',
            $id
        );

        try {
            $executed = $statement->execute();
        } catch (Exception $exception) {
            $executed = false;
        }

        $connection->close();

        return $executed;
    }

    public static function updateUserData(User $user): bool {
        $connection = self::connect();

        try {
            $statement = $connection->prepare(Constants::UPDATE_USER_DATA);
            $userName = $user->getUserName();
            $gamesPlayed = $user->getGamesPlayed();
            $gamesWinned = $user->getGamesWinned();
            $email = $user->getEmail();
            $executed = true;

            $statement->bind_param(
                Constants::USER_DATA_PARAMS,
                $userName,
                $gamesPlayed,
                $gamesWinned,
                $email
            );

            $statement->execute();
        } catch (Exception $exception) {
            $executed = false;
        }

        $connection->close();

        return $executed;
    }

    public static function updateUserPassword(User $user) {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::UPDATE_USER_PASSWORD);
        $email = $user->getEmail();
        $password = $user->getPassword();
        $executed = true;

        $statement->bind_param(
            'ss',
            $password,
            $email
        );

        try {
            $statement->execute();
        } catch (Exception $exception) {
            $executed = false;
        }

        $connection->close();

        return $executed;
    }

    public static function updateUserStatus(User $user): bool {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::UPDATE_USER_STATUS);
        $status = $user->getEnabled();
        $email = $user->getEmail();

        $statement->bind_param(
            'is',
            $status,
            $email
        );

        try {
            $executed = $statement->execute();
        } catch (Exception $exception) {
            $executed = false;
        }

        $connection->close();

        return $executed;
    }

    private static function fetchEmails(bool | mysqli_stmt $statement): array {
        $statement->execute();
        $rows = $statement->get_result();
        $emails = [];

        while ($rows->num_rows !== 0 && $row = $rows->fetch_array()) {
            $emails[] = $row['email'];
        }

        $rows->free_result();

        return $emails;
    }

    private static function fetchUsers(bool | mysqli_stmt $statement): array {
        $statement->execute();
        $rows = $statement->get_result();
        $users = [];

        while ($rows->num_rows !== 0 && $row = $rows->fetch_array()) {
            $users[] = new User(
                $row['userName'],
                $row['email'],
                $row['password'],
                $row['gamesPlayed'],
                $row['gamesWinned'],
                $row['enabled']
            );
        }

        $rows->free_result();

        return $users;
    }
}