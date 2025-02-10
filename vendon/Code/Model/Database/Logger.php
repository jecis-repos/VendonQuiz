<?php

declare(strict_types=1);

namespace Vendon\Code\Model\Database;

use RuntimeException;

class Logger
{
    private const ERROR_LOG = 'Logs/error.log';

    public static function log(string $message): void
    {
        if (!is_dir('Logs') && !mkdir('Logs')) {
            throw new RuntimeException("Could not create Logs directory");
        }

        $file = fopen(self::ERROR_LOG, 'a');
        if ($file === false) {
            throw new RuntimeException("Could not open log file");
        }

        fwrite($file, date('Y-m-d H:i:s').' - '.$message.PHP_EOL);
        fclose($file);
    }
}
