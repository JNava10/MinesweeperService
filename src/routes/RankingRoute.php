<?php

use model\Status;

class RankingRoute {
    public static function handleRequest(array $args, array | null $body, string $method): bool|string {
        $response['status'] = self::getStatus($args, $body, $method);

        if ($response['status']->getCode() === 200) {
            $response['data'] = match ($method) {
                Constants::GET => self::handleGetRequest($args)
            };
        }

        return json_encode($response);
    }

    private static function handleGetRequest(): bool|array {
        return RankingController::get();
    }

    private static function getStatus(array $args, ?array $body, string $method): Status {
        if ($method === Constants::GET) {
            if (isset($body)) {
                $status = new Status(400, Constants::RESPONSES[400]);
            } elseif (isset($args[2]) ) {
                $status = new Status(414, Constants::RESPONSES[414]);
            } else {
                $status = new Status(200, Constants::RESPONSES[200]);
            }
        } else {
            $status = new Status(405, Constants::RESPONSES[405]);
        }

        return $status;
    }
}