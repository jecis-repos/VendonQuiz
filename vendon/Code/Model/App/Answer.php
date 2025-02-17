<?php

namespace Vendon\Code\Model\App;

use Vendon\Code\Model\Database\Database;

class Answer extends Model
{
    public int $id;
    public int $question_id;
    public string $answer;
    public bool $is_correct;
    protected array $fields = ['answer_id', 'question_id', 'answer', 'is_correct'];
    protected string $table = 'answers';

    public function getAnswersByQuestion(int $questionId): array
    {
        return $this->find('question_id', $questionId);
    }

    public function find(string $column, mixed $data): array
    {
        $sql = "SELECT id, question_id, answer, is_correct FROM $this->table WHERE $column = ?";
        $mysqli = Database::newConnection();
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $data);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
