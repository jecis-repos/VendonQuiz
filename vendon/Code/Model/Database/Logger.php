<?php

declare(strict_types=1);

namespace Vendon\Code\Model\Database;

class Logger
{
    public static function log(string $message): void
    {
        // PHP-FPM forwards this to Docker logs without requiring a writable checkout.
        error_log($message);
    }
}
