<?php

namespace controller;

use model\User;

class UserController {
    public static function getAllUsers() {
        return Database::selectAllUsers();
    }

    public static function getUserByEmail(string $email): array {
        return Database::selectUserByEmail($email);
    }

    public static function getUserByUserName(string $userName): array {
        return Database::selectUserByUserName($userName);
    }

    public static function insertUser(User $user): bool {
        return Database::insertUser($user);
    }

    public static function updateUserData(User $user): bool {
        return Database::updateUserData($user);
    }

    public static function updateUserPassword(User $user): bool {
        return Database::updateUserPassword($user);
    }

    public static function deleteUser(string $email): bool {
        return Database::deleteUser($email);
    }
}