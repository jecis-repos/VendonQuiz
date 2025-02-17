<?php

namespace Vendon\Code\Model\App;

use Vendon\Code\Model\Database\Database;

class Score extends Model
{
    public int $id;
    public int $quiz_id;
    public int $user_id;
    public int $score;
    protected string $table = 'scores';
    protected array $fields = [
        'id',
        'quiz_id',
        'user_id',
        'score',
    ];
    protected string $byField = 'id';

    public function find(mixed $data)
    {
        $userId = $data['user_id'];
        $quizId = $data['quiz_id'];
        $sql = "SELECT id, user_id, quiz_id, score FROM $this->table WHERE user_id = $userId  AND quiz_id = $quizId";
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
}
