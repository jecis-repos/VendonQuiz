<?php

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
        return (new Database())->query("SELECT * FROM $this->table WHERE $param = $value")->fetch_all(MYSQLI_ASSOC);
    }
}
