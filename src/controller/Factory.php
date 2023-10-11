<?php

namespace controller;

class Factory {
    const MINE = 'M';
    const HIDDENBOX = 'T';

    static function buildHiddenTable($tableLength, $mineQuantity): array {
        $table = array_fill(0, $tableLength - 1, 0);

        self::putMines($table, $mineQuantity);
        self::calculateHelps($table);

        return $table;
    }

    static function buildProgressTable($tableLength): array {
        return array_fill(0, $tableLength - 1, self::HIDDENBOX);
    }

    private static function putMines(array $table, $mineQuantity): array {
        for ($i = 0; $i < $mineQuantity; $i++) {
            $minePosition = rand(0, count($table));

            $table[$minePosition] = self::MINE;
        }

        return $table;
    }

    private static function calculateHelps(array $table): bool {
        for ($i = 0; $i < count($table); $i++) {
            if ($table[$i + 1] == self::MINE) {
                $table[$i] = 1;
            } else if ($table[$i + 2] == self::MINE) {
                $table[$i] = 2;
            }
        }

        return true;
    }
}