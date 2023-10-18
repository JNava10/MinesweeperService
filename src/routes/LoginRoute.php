<?php

use model\Status;

class LoginRoute {
    public static function handleRequest(array | null $body, string $method): bool|string {
        $response = [];
        $status = self::getStatus($body, $method);
        $response['status'] = $status;

        if ($status->getCode() === 200) {
            $response['data'] = match ($method) {
                Constants::POST => self::handlePostRequest($body)
            };
        }

        return json_encode($response);
    }

    private static function getStatus(array $body, string $method): Status {
        if ($method === Constants::POST) {
            if (
                !isset($body['email']) ||
                !isset($body['password'])
            ) {
                $status = new Status(400, Constants::RESPONSES[400]);
            } elseif (!LoginController::checkIfEmailExists($body['email'])) {
                $status = new Status(404, Constants::RESPONSES[404]);
            } elseif (isset($args[2])) {
                $status = new Status(414, Constants::RESPONSES[414]);
            } else {
                $status = new Status(200, Constants::RESPONSES[200]);
            }
        } else {
            $status = new Status(405, Constants::RESPONSES[405]);
        }

        return $status;
    }

    private static function handlePostRequest(array $body): array {
        return array('user' => LoginController::isLoginCorrect($body['email'], $body['password']));
    }
}