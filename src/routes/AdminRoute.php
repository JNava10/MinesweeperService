<?php

namespace routes;

use Constants;
use controller\UserController;
use model\Status;
use model\User;

class AdminRoute {
    private const VALID_SUBROUTES = [
        'users' => [
            'changedata',
            'changepassword',
            'changestatus'
        ]
    ];

    public static function handleRequest(array $args, array | null $body, string $method): bool|string {
        $response = [];
        $status = self::getStatus($args, $body, $method);
        $response['status'] = $status;

        if ($status->getCode() === 200 && $args[2] === array_keys(self::VALID_SUBROUTES)[0]) {
            $response = self::handleUserRequest($args, $body, $method);
        }

        return json_encode($response);
    }

    private static function getStatus(array $args, array | null $body, string $method): array|Status {
        return match ($method) {
            Constants::GET => self::getResponseStatus($args, $body),
            Constants::POST => self::postResponseStatus($args, $body),
            Constants::PUT => self::putResponseStatus($args, $body),
            Constants::DELETE => self::deleteResponseStatus($args, $body),
            default => new Status(405, Constants::RESPONSES[405])
        };
    }

    private static function handleUserRequest(array $args, ?array $body, string $method): array {
        $response = [];

        if ($method === Constants::GET && !$args[3]) {
            $response = UserController::getAllUsers();
        } elseif ($method === Constants::GET && $args[3]) {
            $response = UserController::getUserByUserName($args[3]);
        } elseif ($method === Constants::POST && $args[2] === self::VALID_SUBROUTES[0]) {
            $user = new User(
                $body['userName'],
                $body['email'],
                null,
                $body['gamesPlayed'],
                $body['gamesWinned'],
                $body['enabled']
            );

            $response = UserController::insertUser($user);
        } elseif (
            $method === Constants::PUT &&
            $args[2] === array_keys(self::VALID_SUBROUTES)[0] &&
            $args[3] === self::VALID_SUBROUTES['users'][0]
        ) {
            $userData = UserController::getUserData($body['email']);
            $response['status'] = new Status(400, Constants::RESPONSES[400]);

            if (
                $body['userName'] !== $userData->getUserName() ||
                $body['gamesPlayed'] !== $userData->getGamesPlayed() ||
                $body['gamesWinned'] !== $userData->getGamesWinned()
            ) {
                $user = new User(
                    $body['userName'],
                    $body['email'],
                    null,
                    $body['gamesPlayed'],
                    $body['gamesWinned'],
                    $body['enabled']
                );

                if (UserController::updateUserData($user)) {
                    $response['status'] = new Status(200, Constants::RESPONSES[200]);
                }
            } else {
                $response['status'] = new Status(409, Constants::RESPONSES[409]);
            }
        } elseif (
            $method === Constants::PUT &&
            $args[2] === array_keys(self::VALID_SUBROUTES)[0] &&
            $args[3] === self::VALID_SUBROUTES['users'][1]
        ) {
            $currentPassword = UserController::getUserPassword($body['email']);
            $response['status'] = new Status(400, Constants::RESPONSES[400]);

            if ($body['password'] !== $currentPassword) {
                $user = new User(
                    null,
                    $body['email'],
                    $body['password'],
                    null,
                    null,
                    null
                );

                if (UserController::updateUserPassword($user)) {
                    $response['status'] = new Status(200, Constants::RESPONSES[200]);
                }
            } else {
                $response['status'] = new Status(409, Constants::RESPONSES[409]);
            }
        } elseif (
            $method === Constants::PUT &&
            $args[2] === array_keys(self::VALID_SUBROUTES)[0] &&
            $args[3] === self::VALID_SUBROUTES['users'][2]
        ) {
            $userStatus = UserController::getUserStatus($body['email']);
            $response['status'] = new Status(400, Constants::RESPONSES[400]);

            if ($body['enabled'] !== $userStatus) {
                $user = new User(
                    null,
                    $body['email'],
                    null,
                    null,
                    null,
                    $body['enabled']
                );

                if (UserController::updateUserStatus($user)) {
                    $response['status'] = new Status(200, Constants::RESPONSES[200]);
                }
            } else {
                $response['status'] = new Status(409, Constants::RESPONSES[409]);
            }
        } elseif (
            $method === Constants::DELETE &&
            $args[2] === array_keys(self::VALID_SUBROUTES)[0] &&
            isset($args[3])
        ) {
            if (UserController::deleteUser($args[3])) {
                $response['status'] = new Status(200, Constants::RESPONSES[200]);
            } else {
                $response['status'] = new Status(500, Constants::RESPONSES[500]);
            }
        }

        return $response;
    }

    private static function getResponseStatus(array $args, ?array $body): Status {
        $status = new Status(200, Constants::RESPONSES[200]);

        if (isset($body) || !in_array($args[2], array_keys(self::VALID_SUBROUTES))) {
            $status = new Status(400, Constants::RESPONSES[400]);
        } else if (!in_array($args[2], array_keys(self::VALID_SUBROUTES))) {
            $status = new Status(404, Constants::RESPONSES[404]);
        }

        return $status;
    }

    private static function postResponseStatus(array $args, ?array $body): Status {
        $status = new Status(200, Constants::RESPONSES[200]);

        if (
            (isset($body) && !$body['email']) ||
            (isset($body) && !$body['userName']) ||
            (isset($body) && !isset($body['password'])) ||
            (isset($body) && !isset($body['gamesPlayed'])) ||
            (isset($body) && !isset($body['gamesWinned']))
        ) {
            $status = new Status(400, Constants::RESPONSES[400]);
        } else if (isset($args[3])) {
            $status = new Status(414, Constants::RESPONSES[414]);
        }

        return $status;
    }

    private static function putResponseStatus(array $args, ?array $body): Status {
        $status = new Status(200, Constants::RESPONSES[200]);

        if (
            !isset($body)
        ) {
            echo !array_search($body['email'], UserController::getAllEmails());
            $status = new Status(400, Constants::RESPONSES[400]);
        } else if (
            !in_array($args[2], array_keys(self::VALID_SUBROUTES)) ||
            !in_array($args[3], self::VALID_SUBROUTES['users'])
        ) {
            $status = new Status(404, Constants::RESPONSES[404]);
        } else if (isset($args[4])) {
            $status = new Status(414, Constants::RESPONSES[414]);
        }

        return $status;
    }

    private static function deleteResponseStatus(array $args, ?array $body): Status {
        $status = new Status(200, Constants::RESPONSES[200]);

        if (
            isset($body) ||
            !isset($args[3]) ||
            !intval($args[3])
        ) {
            $status = new Status(400, Constants::RESPONSES[400]);
        } else if (!in_array($args[2], array_keys(self::VALID_SUBROUTES))) {
            $status = new Status(404, Constants::RESPONSES[404]);
        } else if (isset($args[4])) {
            $status = new Status(414, Constants::RESPONSES[414]);
        }

        return $status;
    }
}