<?php

namespace controller;

use model\User;

class UserController {
    static public function getAllUsers() {
        return Database::selectAllUsers();
    }

    static public function getUserByEmail(string $email) {
        return Database::selectUserByEmail($email);
    }

    static public function getUserByUserName(string $userName) {
        return Database::selectUserByUserName($userName);
    }

    static public function insertUser(User $user) {
        return Database::insertUser($user);
    }
}