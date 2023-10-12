<?php

class Constants {

    // DATABASE CREDENTIALS //

    const HOSTNAME = 'localhost';
    const USERNAME = 'juan';
    const PASSWORD = '1234';

    // QUERIES //
    const SELECT_ALL_USERS = "SELECT * FROM users";
    const SELECT_USER_BY_EMAIL = "SELECT * FROM users WHERE email = ?";
    const SELECT_USER_BY_USERNAME = "SELECT * FROM users WHERE userName = ?";
    const SELECT_USER_BY_ID = "SELECT * FROM users WHERE id = ?";
    const INSERT_USER = "INSERT INTO users VALUES (?, ?, ?, ?, ?)";
    const UPDATE_USER_BY_EMAIL = "UPDATE users SET (?, ?, ?, ?, ?) WHERE email = ?";
    const DELETE_USER = "DELETE FROM users WHERE email = ?";
    public const USER_PARAMS = 'sssii';
}