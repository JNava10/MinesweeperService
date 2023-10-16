<?php

namespace controller;

use model\User;

class UserController {
    public static function getAllUsers() {
        return Database::selectAllUsers();
    }

    public static function getAllEmails() {
        return Database::selectAllEmails();
    }

    public static function getUserByEmail(string $email): array {
        return Database::selectUserByEmail($email);
    }

    public static function getUserByUserName(string $userName): array {
        return Database::selectUserByUserName($userName);
    }

    public static function getUserData(string $email): User | bool {
        return Database::selectUserData($email);
    }

    public static function getUserPassword(string $email) {
        return Database::selectUserPassword($email);
    }

    public static function getUserStatus(string $email) {
        return Database::selectUserStatus($email);
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

    public static function updateUserStatus(User $user) {
        return Database::updateUserStatus($user);
    }

    public static function deleteUser(int $id): bool {
        return Database::deleteUser($id);
    }
}