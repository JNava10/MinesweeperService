<?php

namespace model;

class Game {
    public $gameId;
    public $userId;
    public $progress;
    public $hidden;
    public $finished;

    public function __construct($userId, $progress, $hidden, $finished) {
        $this->userId = $userId;
        $this->progress = $progress;
        $this->hidden = $hidden;
        $this->finished = $finished;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function getProgress(): array
    {
        return $this->progress;
    }

    public function setProgress($progress): void
    {
        $this->progress = $progress;
    }

    public function getHidden(): array
    {
        return $this->hidden;
    }

    public function setHidden($hidden): void
    {
        $this->hidden = $hidden;
    }

    public function getFinished(): int
    {
        return $this->finished;
    }

    public function setFinished($finished): void
    {
        $this->finished = $finished;
    }

    public function getGameId(): int
    {
        return $this->gameId;
    }

    public function setGameId($gameId): void
    {
        $this->gameId = $gameId;
    }

    public function setProgressGameBox($content, $index) {
        $this->progress[$index] = $content;
    }

    public function getBoxesCount() {
        return count($this->progress);
    }
}