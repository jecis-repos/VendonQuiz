<?php

declare(strict_types=1);

namespace Vendon\Code\Model\API;

use JsonException;

class RequestApi
{
    /**
     * @return array
     * @throws JsonException
     */
    public static function getPost(): array
    {
        return json_decode(
            file_get_contents('php://input'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @param $data
     *
     * @return string
     */
    public static function jsonEncode($data): string
    {
        try {
            return json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $data
     *
     * @return array
     */
    public static function jsonDecode($data): array
    {
        try {
            return json_decode($data, JSON_THROW_ON_ERROR, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return [$e->getMessage()];
        }
    }
}
