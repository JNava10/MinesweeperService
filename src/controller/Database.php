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
                Constants::HOSTNAME,
                Constants::USERNAME,
                Constants::PASSWORD
            );
        } catch (Exception $exception) {
            $connection = $exception->getMessage();
        } finally {
            return $connection;
        }
    }

    static public function selectAllUsers() {
        $statement = self::connect()->prepare(Constants::SELECT_ALL_USERS);

        return self::fetchUsers($statement);
    }

    static public function selectUserByUserName(string $userName) {
        $statement = self::connect()->prepare(Constants::SELECT_USER_BY_USERNAME);
        $statement->bind_param(
            Constants::USER_PARAMS,
            $userName
        );

        return self::fetchUsers($statement);
    }

    static public function selectUserByEmail(string $email) {
        $statement = self::connect()->prepare(Constants::SELECT_USER_BY_EMAIL);

        return self::fetchUsers($statement);
    }

    static public function insertUser(User $user) {
        $statement = self::connect()->prepare(Constants::INSERT_USER);
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

        return $executed;
    }

    static public function insertUsers(array $users) {
        // TODO
    }

    private static function fetchUsers(bool | mysqli_stmt $statement) {
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

    static public function deleteUser(string $email) {
        $statement = self::connect()->prepare(Constants::DELETE_USER);
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

        return $executed;
    }
}