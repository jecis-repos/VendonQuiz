<?php

namespace Vendon\Code\Model\App;

use Vendon\Code\Model\Database\Database;

class Answer extends Model
{
    protected array $fields = ['answer_id', 'question_id', 'answer', 'is_correct'];
    protected string $table = 'answers';

    public int $id;
    public int $question_id;
    public string $answer;
    public bool $is_correct;

    public function find(string $column, mixed $data)
    {
        $sql = "SELECT id, question_id, answer, is_correct FROM $this->table WHERE $column = '$data'";
        $conn = Database::newConnection();
        $result = $conn->query($sql);
        $model = null;
        if ($result->num_rows > 0) {
            $model = $result->fetch_all(MYSQLI_ASSOC);
        }

        $conn->close();
        $result->close();
        return $model;
    }

    public function getAnswersByQuestion(int $questionId): array
    {
        return $this->find('question_id', $questionId);
    }
}
