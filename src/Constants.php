<?php

class Constants {

    // DATABASE CREDENTIALS //

    const HOSTNAME = 'localhost';
    const USERNAME = 'juan';
    const PASSWORD = '1234';

    //DATABASE QUERIES //

    const SELECT_ALL_USERS = "SELECT * FROM users";
    const SELECT_USER_BY_EMAIL = "SELECT * FROM users WHERE email = ?";
    const SELECT_USER_BY_USERNAME = "SELECT * FROM users WHERE userName = ?";
    const SELECT_USER_BY_ID = "SELECT * FROM users WHERE id = ?";
    const INSERT_USER = "INSERT INTO users VALUES (?, ?, ?, ?, ?)";
    const UPDATE_USER_PASSWORD = "UPDATE users SET password = ? WHERE email = ?";
    const UPDATE_USER_DATA = "UPDATE users SET userName = ?, gamesPlayed = ?, gamesWinned = ? WHERE email = ?";
    const DELETE_USER = "DELETE FROM users WHERE email = ?";

    // DATABASE PARAMS //

    const USER_PARAMS = 'sssii';
    const USER_PASSWORD_PARAMS = 'ss';
    const USER_DATA_PARAMS = 'siis';
}