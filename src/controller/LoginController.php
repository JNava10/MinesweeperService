<?php

use controller\Database;
use model\User;

class LoginController {
    public static function checkIfEmailExists(string $email): bool {
        return Database::checkIfEmailExists($email);
    }

    public static function isLoginCorrect(string $email, string $password): User | bool {
        if (Database::selectUserPassword($email) === $password) {
            return Database::selectUserByEmail($email)[0];
        } else {
            return false;
        }
    }
}