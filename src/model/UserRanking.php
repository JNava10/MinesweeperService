<?php

namespace model;

class UserRanking {

    public $userName;
    public $gamesPlayed;
    public $gamesWinned;

    public function __construct($userName, $gamesPlayed, $gamesWinned) {
        $this->userName = $userName;
        $this->gamesPlayed = $gamesPlayed;
        $this->gamesWinned = $gamesWinned;
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
}