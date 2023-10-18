<?php

namespace model;

class User {
    public $userName;
    public $email;
    public $password;
    public $gamesPlayed;
    public $gamesWinned;
    public $role;
    public $enabled;

    /**
     * @param $userName
     * @param $email
     * @param $password
     * @param $gamesPlayed
     * @param $gamesWinned
     */
    public function __construct($userName, $email, $password, $gamesPlayed, $gamesWinned, $enabled) {
        $this->userName = $userName;
        $this->email = $email;
        $this->password = $password;
        $this->gamesPlayed = $gamesPlayed;
        $this->gamesWinned = $gamesWinned;
        $this->enabled = $enabled;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string | null
    {
        return $this->password;
    }

    public function getGamesPlayed(): int
    {
        return $this->gamesPlayed;
    }

    public function getGamesWinned(): int
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

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }
}