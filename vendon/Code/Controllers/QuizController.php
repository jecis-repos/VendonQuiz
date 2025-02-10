<?php

namespace Vendon\Code\Controllers;

use JsonException;
use Vendon\Code\Model\API\RequestApi;
use Vendon\Code\Model\App\Answer;
use Vendon\Code\Model\App\Quiz;
use Vendon\Code\Model\App\Score;
use Vendon\Code\Model\App\User;
use Vendon\Code\Model\Database\Logger;

class QuizController
{
    private const VIEW_DIR = __DIR__.'/../../views/';

    public function index(): void
    {
        list($query, $post) = $this->parseUrl();

        $existingUser = !((new User())->find('name', $post['name']) === null);
        if (!$existingUser) {
            (new User())->save(
                $post
            );
        }

        $user = new User();
        $result = $user->find('name', $post['name']);

        $score = new Score();
        $existingScore = $score->find(['user_id' => $result->getId(), 'quiz_id' => $query['quizId']]);
        if (!$existingScore) {
            $score->save(['user_id' => $result->getId(), 'quiz_id' => $query['quizId'], 'score' => 0]);
        } else {
            $existingScore->update([
                'id' => $existingScore->id,
                'user_id' => $result->getId(),
                'quiz_id' => $query['quizId'],
                'score' => 0
            ]);
        }

        echo file_get_contents(self::VIEW_DIR.'/questions.html');
    }

    public function get(): string
    {
        return RequestApi::jsonEncode((new Quiz())->getAll());
    }

    /**
     * @throws JsonException
     */
    public function getAssoc(): string
    {
        $post = RequestApi::getPost();

        if (!isset($post['quiz_id'])) {
            return RequestApi::jsonEncode(['error' => 'quiz_id is required']);
        }

        $quizId = (int)$post['quiz_id'];

        $questionsData = (new Quiz())->getQuizQuestions($quizId);
        $questions = [];

        foreach ($questionsData as $key => $question) {
            $questionsData[$key]['answers'] = (new Answer())->getAnswersByQuestion($question['id']);
        }

        $questions['quiz'] = (new Quiz())->getQuizById($quizId);
        $questions['questions'] = $questionsData;

        return RequestApi::jsonEncode($questions);
    }

    public function post()
    {
        $post = RequestApi::getPost();

        $user = new User();
        $userId = $user->find('name', $post['answers']['user'])->getId();
        $quizId = $post['quizId'];
        $score = new Score();
        $existingScore = $score->find(['user_id' => $userId, 'quiz_id' => $quizId]);

        if ((bool)$post['answers']['correct'] === true) {
            Logger::log($post['answers']['correct'].' is_correct');
            (new Score())->update([
                'id' => $existingScore->id,
                'user_id' => $userId,
                'quiz_id' => $quizId,
                'score' => $existingScore->score + 1
            ]);
        }

        return RequestApi::jsonEncode($existingScore->score++);
    }

    private function formatTagsData(array $post): User
    {
        $tags = new User();

        return $tags->setData($post);
    }

    public function save(): string
    {
        $post = RequestApi::getPost();

        if (!isset($post['username'])) {
            return RequestApi::jsonEncode(['error' => 'name is required']);
        }

        $tags = $this->formatTagsData($post);

        if ($tags->getId()) {
            $tags->update($tags->map());
        } else {
            $tags->save($tags->map());
        }

        return RequestApi::jsonEncode($tags->map());
    }

    public function result()
    {
        list($query, $post) = $this->parseUrl();
        echo file_get_contents(self::VIEW_DIR.'/result.html');
    }

    /**
     * @return array
     */
    public function parseUrl(): array
    {
        $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https')."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url = $actual_link;
        $parts = parse_url($url);
        parse_str($parts['query'], $query);
        Logger::log(implode(', ', $parts));
        $post = ['name' => $query['username']];

        return array($query, $post);
    }
}
