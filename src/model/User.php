<?php

namespace model;

class User {
    public $userName;
    public $email;
    public $password;
    public $gamesPlayed;
    public $gamesWinned;

    /**
     * @param $userName
     * @param $email
     * @param $password
     * @param $gamesPlayed
     * @param $gamesWinned
     */
    public function __construct($userName, $email, $password, $gamesPlayed, $gamesWinned) {
        $this->userName = $userName;
        $this->email = $email;
        $this->password = $password;
        $this->gamesPlayed = $gamesPlayed;
        $this->gamesWinned = $gamesWinned;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getGamesPlayed()
    {
        return $this->gamesPlayed;
    }

    public function getGamesWinned()
    {
        return $this->gamesWinned;
    }

    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function setGamesPlayed($gamesPlayed): void
    {
        $this->gamesPlayed = $gamesPlayed;
    }

    public function setGamesWinned($gamesWinned): void
    {
        $this->gamesWinned = $gamesWinned;
    }
}