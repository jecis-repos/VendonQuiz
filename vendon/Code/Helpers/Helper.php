<?php
declare(strict_types=1);

namespace Vendon\Code\Helpers;

use Vendon\Code\Model\API\RequestApi;
use Vendon\Code\Model\Database\Logger;

class Helper
{
    public function trimInput($post): ?array
    {
        return array_map(function ($item) {
            return is_array($item) ? $this->trimInput($item) : htmlspecialchars(trim($item));
        }, $post);
    }

    public function validate($post): ?string
    {
        if (empty(array_filter(array_values($post)))) {
            return RequestApi::jsonEncode(
                [
                    'message' => 'Neviens lauks nav aizpildīts',
                    'saved' => 0
                ]
            );
        }

        $msg = [];
        foreach ($post as $key => $value) {
            Logger::log(RequestApi::jsonEncode([$key => $value]));
            if (empty($value)) {
                $msg[] = [$key => 'Laukā nav norādīti dati: '];
            }
        }

        if (!empty($msg)) {
            return RequestApi::jsonEncode(
                [
                    'message' => $msg,
                    'saved' => 0
                ]
            );
        }

        return null;
    }
}
