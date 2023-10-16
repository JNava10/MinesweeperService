<?php

namespace model;

class Game {
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

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function getProgress()
    {
        return $this->progress;
    }

    public function setProgress($progress): void
    {
        $this->progress = $progress;
    }

    public function getHidden()
    {
        return $this->hidden;
    }

    public function setHidden($hidden): void
    {
        $this->hidden = $hidden;
    }

    public function getFinished()
    {
        return $this->finished;
    }

    public function setFinished($finished): void
    {
        $this->finished = $finished;
    }
}