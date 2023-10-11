<?php

namespace model;

class Minesweeper {
    public $player;
    public $hidden;
    public $progress;
    public $winned;

    public function __construct($player, $hidden, $progress, $winned) {
        $this->player = $player;
        $this->hidden = $hidden;
        $this->progress = $progress;
        $this->winned = $winned;
    }

    /**
     * @return mixed
     */
    public function getPlayer() {
        return $this->player;
    }

    /**
     * @param mixed $player
     */
    public function setPlayer($player) {
        $this->player = $player;
    }

    /**
     * @return mixed
     */
    public function getHidden() {
        return $this->hidden;
    }

    /**
     * @param mixed $hidden
     */
    public function setHidden($hidden) {
        $this->hidden = $hidden;
    }

    /**
     * @return mixed
     */
    public function getProgress() {
        return $this->progress;
    }

    /**
     * @param mixed $progress
     */
    public function setProgress($progress) {
        $this->progress = $progress;
    }

    /**
     * @return mixed
     */
    public function getWinned() {
        return $this->winned;
    }

    /**
     * @param mixed $winned
     */
    public function setWinned($winned) {
        $this->winned = $winned;
    }
}