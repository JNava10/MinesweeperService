<?php

namespace routes;

use Constants;
use controller\PlayController;
use controller\AdminController;
use factory\GameTableFactory;
use model\Status;


class PlayRoute {
    private const VALID_SUBROUTES = [
        'create'
    ];

    public static function handleRequest(array $args, ?array $body, string $method): bool|string {
        $response = [];
        $response['status'] = self::getStatus($args, $body, $method);

        if ($response['status']->getCode() === 200) {
            $response['data'] = match ($method) {
                Constants::GET => self::handleGetRequest($args, $body),
                Constants::POST => self::handlePostRequest($args, $body)
            };
        }

        return json_encode($response);
    }

    private static function handlePostRequest(array $args, ?array $body) {
        $response = [];

        if (isset($args[2]) && $args[2] === 'surrender') {
            // TODO: Surrender
        } else {
            $response['gameStatus'] = PlayController::updateGame($body['email'], $body['password'], $body['gameBox']);
        }
    }

    private static function handleGetRequest(array $args, array $body): array {
        $userId = AdminController::getUserId($body['email'], $body['password']);

        if (!isset($args[2])) {
            $response['games'] = PlayController::getUserOpenedGames($userId);
        } elseif ($args[2] === self::VALID_SUBROUTES[0] && !isset($args[3])) {
            $response['game'] = PlayController::createGame(Constants::DEFAULT_BOXES, Constants::DEFAULT_MINES, $userId);
        } elseif ($args[2] === self::VALID_SUBROUTES[0] && $args[3]) {
            $response['game'] = PlayController::createGame($args[3], $args[4], $userId);
        } elseif (intval($args[2])) {
            $response['game'] = PlayController::getGame($args[2]);
        }

        return $response;
    }

    private static function getStatus(array $args, array $body, string $method): Status {
        $userId = AdminController::getUserId($body['email'], $body['password']);

        if ($method === Constants::POST) {
            if (
                !$args[2] ||
                !intval($args[2]) ||
                !isset($body['email']) ||
                !isset($body['password']) ||
                !isset($body['gameBox'])
            ) {
                $status = new Status(400, Constants::RESPONSES[400]);
            } elseif (!PlayController::checkIfEmailExists($body['email'])) {
                $status = new Status(404, Constants::RESPONSES[404]);
            }
            else {
                $status = new Status(200, Constants::RESPONSES[200]);
            }
        } elseif ($method === Constants::GET) {
            if (
                (isset($args[2]) && in_array($args[2], self::VALID_SUBROUTES) && isset($args[3]) && !isset($args[4])) ||
                isset($args[3]) &&
                ($args[3] < $args[4] ||
                $args[3] < 1 ||
                $args[4] < 1) ||
                !$body ||
                !isset($body['email']) ||
                !isset($body['password'])
            )  {
                $status = new Status(400, Constants::RESPONSES[400]);
            } elseif (
                !PlayController::checkIfEmailExists($body['email']) ||
                PlayController::checkIfEmailExists($body['email']) &&
               (!intval($args[2]) && !in_array($args[2], self::VALID_SUBROUTES) ||
                intval($args[2]) && !in_array($args[2], PlayController::getGameIdList()))
            ) {
                echo  intval($args[2]);
                $status = new Status(404, Constants::RESPONSES[404]);
            } elseif (
                !in_array($args[2], self::VALID_SUBROUTES) &&
                PlayController::getGameUser($args[2]) !== $userId
            ) {
                echo !in_array($args[2], self::VALID_SUBROUTES);
                $status = new Status(403, Constants::RESPONSES[403]);
            }
            else {
                $status = new Status(200, Constants::RESPONSES[200]);
            }
        } else {
            $status = new Status(405, Constants::RESPONSES[405]);
        }

        return $status;
    }
}