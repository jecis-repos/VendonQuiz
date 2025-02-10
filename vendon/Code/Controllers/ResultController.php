<?php

namespace Vendon\Code\Controllers;

use JsonException;
use Vendon\Code\Model\API\RequestApi;
use Vendon\Code\Model\App\Score;
use Vendon\Code\Model\App\User;

class ResultController
{
    private const VIEW_DIR = __DIR__.'/../../views/';

    public function index(): void
    {
        echo file_get_contents(self::VIEW_DIR.'/result.html');
    }

    /**
     * @throws JsonException
     */
    public function getAssoc(): string
    {
        $post = RequestApi::getPost();
        $user = new User();
        $result = $user->find('name', $post['name']);

        $score = new Score();
        $existingScore = $score->find(['user_id' => $result->getId(), 'quiz_id' => $post['quiz_id']]);

        if (!isset($post['quiz_id'])) {
            return RequestApi::jsonEncode(['error' => 'quiz_id is required']);
        }

        return RequestApi::jsonEncode(
            [
                'user_score' => $existingScore->score,
                'questions' => $post['questions'],
                'user' => $result,
            ]
        );
    }
}
