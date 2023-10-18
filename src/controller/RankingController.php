<?php

use controller\Database;

class RankingController {

    public static function get(): array|bool {
        return Database::selectAllRanking();
    }
}