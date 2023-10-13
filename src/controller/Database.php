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

    public static function deleteUser(string $email): bool {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::DELETE_USER);
        $executed = true;

        $statement->bind_param(
            Constants::USER_PARAMS,
            $userName,
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

    public static function updateUserData(User $user): bool {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::INSERT_USER);
        $userName = $user->getUserName();
        $email = $user->getEmail();
        $gamesPlayed = $user->getGamesPlayed();
        $gamesWinned = $user->getGamesWinned();
        $executed = true;

        $statement->bind_param(
            Constants::USER_DATA_PARAMS,
            $userName,
            $gamesPlayed,
            $gamesWinned,
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

    public static function updateUserPassword(User $user) {
        $connection = self::connect();
        $statement = $connection->prepare(Constants::INSERT_USER);
        $email = $user->getEmail();
        $password = $user->getPassword();
        $executed = true;

        $statement->bind_param(
            Constants::USER_PASSWORD_PARAMS,
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
                $row['gamesWinned']
            );
        }

        $rows->free_result();

        return $users;
    }
}