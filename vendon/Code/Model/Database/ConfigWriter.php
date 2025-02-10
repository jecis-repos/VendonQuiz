<?php
declare(strict_types=1);

namespace Vendon\Code\Model\Database;

use JsonException;
use RuntimeException;

class ConfigWriter
{
    /**
     * Database configuration file
     */
    private const CONFIG_ENV = 'dbData.json';

    /**
     * @return bool
     */
    public static function dbExist(): bool
    {
        return file_exists(self::CONFIG_ENV);
    }

    /**
     *
     * @param string $vars
     * @return string
     */
    public static function writeDataToFile(string $vars): string
    {
        try {
            $file = fopen(self::CONFIG_ENV, 'wb+');
            if ($file === false) {
                throw new RuntimeException("Unable to open file!");
            }

            fwrite($file, PHP_EOL . $vars . PHP_EOL);
            fclose($file);
            return 'true';
        } catch (\Exception $e) {
            return 'false';
        }
    }

    /**
     * @param string $key
     * @return null|string
     */
    public static function readDataFromFile(string $key): ?string
    {
        $fileContent = file_get_contents(self::CONFIG_ENV);
        if ($fileContent === false) {
            return null;
        }

        try {
            $data = json_decode($fileContent, true, 512, JSON_THROW_ON_ERROR);
            return $data[$key] ?? null;
        } catch (JsonException | \Exception $e) {
            return null;
        }
    }
}
