<?php

namespace Vendon\Code\Model\Database;

use mysqli;
use Vendon\Code\Model\API\RequestApi;

#[\AllowDynamicProperties]
class Database extends mysqli
{
    private $bindParams;
    private $columns;
    private $types;
    private $insertData;
    private $updateSQL;
    private $id;

    public static function newConnection(): Database
    {
        return (new self(
            ConfigWriter::readDataFromFile('hosts'),
            ConfigWriter::readDataFromFile('lietotajs'),
            ConfigWriter::readDataFromFile('parole'),
            ConfigWriter::readDataFromFile('nosaukums')
        ));
    }

    public function selectTableData(string $table): array
    {
        $sql = 'SELECT * FROM '.$table;
        $result = $this->query($sql);

        $results = [];
        if ($result->num_rows !== 0) {
            while ($row = $result->fetch_object()) {
                $results[] = $row;
            }
        }

        $this->close();
        $result->close();

        return $results;
    }

    public function getByParam(string $table, string $col, string $param): ?array
    {
        $sql = 'SELECT * FROM '.$table.' WHERE '.$col.' = ?';
        Logger::log($sql);
        $mysqli = self::newConnection();
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $param);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return null;
        }

        return $result->fetch_assoc();
    }

    public function getByParameters(string $table, array $columns, string $value)
    {
        $likeParam = '%'.$value.'%';
        $sql = 'SELECT * FROM '.$table.' WHERE '.$columns[0].' LIKE ? OR '.$columns[1].' LIKE ?';

        $mysqli = self::newConnection();
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ss', $likeParam, $likeParam);
        $stmt->execute();
        $result = $stmt->get_result();
        $r = [];
        if ($result->num_rows === 0) {
            return RequestApi::jsonEncode('Šādi dati netika atrasti, lūdzu precizējiet meklējumu');
        }

        while ($obj = $result->fetch_object()) {
            $r[] = $obj;
        }
        $result->close();

        return $r;
    }

    public function parseSql(string $table, array $data, string $optionalType = null, bool $useId = false): void
    {
        $tableData = self::newConnection()->query(
            'SHOW columns FROM '.$table.';'
        )->fetch_all();

        if (!$useId) {
            unset($tableData[0]);
        }

        $optTypType = null;
        foreach ($tableData as $tableVal) {
            $this->bindParams[] = '?';
            $this->columns[] = $tableVal[0];
            if ($optionalType) {
                $this->updateSQL .= $tableVal[0].'=?,';
                if ($tableVal[0] === $optionalType) {
                    $optTypType = $tableVal[0];
                }
            }

            if ($tableVal[1] === 'int') {
                $this->types .= 'i';
            } else {
                $this->types .= 's';
            }
        }

        $data = array_values($data);

        if ($optionalType) {
            $num = count($data);
            $data[$num] = $data[0];
            unset($data[0]);
            reset($data);
        }

        $this->insertData = array_map(static function ($item) {
            return (string)$item;
        }, $data);

        $this->bindParams = implode(',', $this->bindParams);

        if ($optionalType) {
            $this->updateSQL = substr($this->updateSQL, 0, -1);
            $this->updateSQL .= ' WHERE '.$optionalType.'='.'?';
            if ($optTypType === 'int') {
                $this->types .= 'i';
            } else {
                $this->types .= 's';
            }
        }

        $this->columns = implode(',', $this->columns);
    }

    public function preparedStatements(string $sql): bool
    {
        $mysqli = self::newConnection();

        if (!($stmt = $mysqli->prepare($sql))) {
            Logger::log(
                $sql.PHP_EOL.'Prepare failed:  ('.$mysqli->errno.') '.$mysqli->error
            );
        }

        if (!$stmt->bind_param($this->types, ...$this->insertData)) {
            Logger::log(
                'bind err: '.$this->types.$sql.$stmt->errno.$stmt->error
            );
        }

        if (!$stmt->execute()) {
            $mysqli->rollback();
            Logger::log(
                'Execute failed: ('.$stmt->errno.') '.$stmt->error
            );

            return false;
        }

        $mysqli->commit();
        $stmt->close();
        $mysqli->close();

        return true;
    }

    public function getData(string $table, $data, $class)
    {
        $sql = 'SELECT * FROM '.$table.' WHERE name = ?';
        $mysqli = self::newConnection();
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $data);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return false;
        }

        return $result->fetch_object($class);
    }

    public function insert(string $table, $data, $useId): bool
    {
        $this->parseSql($table, $data, null, $useId);

        $sql = 'INSERT INTO '.$table.' ('.$this->columns.') VALUES ('.$this->bindParams.') ';

        $this->preparedStatements($sql);

        return true;
    }

    public function update(string $table, array $data, string $byField): bool
    {
        $this->parseSql($table, $data, $byField);
        $sql = 'UPDATE '.$table.' SET '.$this->updateSQL;

        $this->preparedStatements($sql);

        return true;
    }

    public function drop(string $table): bool
    {
        $sql = 'TRUNCATE '.$table;

        if (self::newConnection()->query($sql)) {
            self::newConnection()->commit();
            self::newConnection()->close();

            return true;
        }

        self::newConnection()->rollback();
        self::newConnection()->close();

        return false;
    }

    public function deleteRow(string $table, string $param): bool
    {
        $sql = 'DELETE FROM '.$table.' WHERE id = ?';
        $mysqli = self::newConnection();
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $param);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $mysqli->commit();
            $stmt->close();
            $mysqli->close();

            return true;
        }

        $mysqli->rollback();
        $stmt->close();
        $mysqli->close();

        return false;
    }

    protected function pingDatabase(Database $databaseInstance): void
    {
        if ($databaseInstance->ping()) {
            Logger::log(
                "Our connection is ok!\n"
            );
        } else {
            Logger::log(
                "Error: %s\n"
            );
        }
    }

    public function getProperty($name)
    {
        return $this->$name;
    }

    public function setProperty($name, $val)
    {
        return $this->$name = $val;
    }

    public function getNumberOfCols(string $table): ?int
    {
        return mysqli_num_rows(
            self::newConnection()->query(
                'describe '.$table.';'
            )
        );
    }
}
