<?php

declare(strict_types=1);

namespace Vendon\Code\Model\App;

use Vendon\Code\Model\Database\Database;

class Quiz extends Model
{
    protected string $table = 'quizes';
    protected array $fields = [
        'id',
        'name',
        'description',
    ];

    protected string $byField = 'id';

    public ?int $id = null;

    public ?string $name;
    public ?string $description;

    protected string $primaryKey = 'id';

    public function getQuizById(int $quizId): array
    {
        return $this->getById($quizId);
    }

    public function getQuizes(): array
    {
        return $this->getAll();
    }

    public function setData(array $post): self
    {
        $tags = new self();

        if (count($post) > count($this->fields)) {
            $tags->setId((int)$post['id']);
        }

        $tags->setQuizId((string)$post['quiz_id']);
        $tags->setQuestion((string)$post['question']);

        return $tags;
    }


    public function getQuizQuestions(int $quizId): array
    {
        $sql = "SELECT id,quiz_id,question FROM vendon.questions WHERE quiz_id = $quizId";
        $conn = Database::newConnection();
        $result = $conn->query($sql);
        $model = [];
        $resultData = [];
        if ($result->num_rows > 0) {
            $model = $result->fetch_all(MYSQLI_ASSOC);
        }

        $conn->close();
        $result->close();

        return $model;
    }

    public function setId(int $param)
    {
        $this->id = $param;

        return $this;
    }

    public function setQuizId(string $param)
    {
        $this->quiz_id = $param;

        return $this;
    }

    public function setQuestion(string $param)
    {
        $this->question = $param;

        return $this;
    }
}
