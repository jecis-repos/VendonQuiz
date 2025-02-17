<?php

namespace Vendon\Code\Model\App;

use AllowDynamicProperties;
use Vendon\Code\Model\Database\Database;

#[AllowDynamicProperties]
class User extends Model
{
    public array $fields = [
        'name'
    ];
    public ?int $id = null;
    public ?string $name;
    protected string $table = 'users';
    protected string $byField = 'id';

    public function find(string $column, mixed $data)
    {
        $sql = "SELECT id, name FROM $this->table WHERE $column = '$data'";
        $conn = Database::newConnection();
        $result = $conn->query($sql);
        $model = null;
        if ($result->num_rows > 0) {
            $model = $result->fetch_object(self::class);
        }

        $conn->close();
        $result->close();
        return $model;
    }

    public function map(): array
    {
        $mappedData = [];

        if ($this->id) {
            $mappedData['id'] = $this->id;
        }

        foreach ($this->fields as $field) {
            $mappedData[$field] = $this->getProperty($field);
        }

        return $mappedData;
    }

    public function getProperty($name): mixed
    {
        return $this->$name;
    }

    public function setData(array $post): self
    {
        $tags = new self();

        if (count($post) > count($this->fields)) {
            $tags->setId((int)$post['id']);
        }

        $tags->setName((string)$post['name']);

        return $tags;
    }

    public function getId(): ?int
    {
        return (int)$this->id;
    }

    public function setId(int $id): User
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return (string)$this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }

    public function getData(string $name)
    {
        return self::get($name);
    }
}
