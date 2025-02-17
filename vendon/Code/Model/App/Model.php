<?php

namespace Vendon\Code\Model\App;

use AllowDynamicProperties;
use Vendon\Code\Model\Database\Database;

#[AllowDynamicProperties]
class Model
{
    protected array $fields;
    protected string $table;
    protected string $byField;


    public function save($data, $useId = false): void
    {
        Database::newConnection()->insert($this->table, $data, $useId);
    }

    public function update(array $data, string $field = null): void
    {
        Database::newConnection()->update($this->table, $data, $field ?: $this->byField);
    }

    public function getAll(): array
    {
        return Database::newConnection()->selectTableData($this->table);
    }

    public function getById(int $id): array
    {
        return Database::newConnection()->getByParam($this->table, $id, $id);
    }

    public function getByParam(array $column, string $value): array
    {
        return Database::newConnection()->getByParameters($this->table, $column, $value);
    }

    public function getByParameters(string $param, string $value): array
    {
        return Database::newConnection()->getByParameters($this->table, (array)$param, $value);
    }

    public function checkDuplicates($name): bool
    {
        return Database::newConnection()
                ->query(
                    'select * 
                    from '.$this->table." 
                    where name = '".$name."'"
                )->num_rows > 0;
    }

    public function delete($data): bool
    {
        return Database::newConnection()->deleteRow($this->table, $data);
    }
}
