<?php

declare(strict_types=1);

namespace Vendon\Code\Model\App;

use Vendon\Code\Model\Database\Database;

class Question extends Model
{
    protected string $table = 'questions';
    protected array $fields = [
        'id',
        'quiz_id',
        'question',
    ];

    public function getByParameters(string $param, string $value): array
    {
        $sql = 'SELECT * FROM '.$this->table.' WHERE $param = ?';
        $mysqli = Database::newConnection();
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $value);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
