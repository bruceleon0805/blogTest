<?php
/**
 * Created by PhpStorm.
 * User: Bruce Leon
 * Date: 18-4-23
 * Time: 21:59
 */

namespace App\Repositories;

use App\Question;
use App\Topic;
use function GuzzleHttp\Promise\queue;

/**
 * Class QuestionRepositories
 * @package App\Repositories
 */
class QuestionRepositories
{
    /**
     * @param $id
     * @return mixed
     */
    public function byIdWithTopics($id)
    {
        return Question::where('id', $id)->with('topics')->first();
    }

    /**
     * @param array $attr
     * @return mixed
     */
    public function create(array $attr)
    {
        return Question::create($attr);
    }

    /**
     * @param array $topics
     * @return array
     */
    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic) {
            if (is_numeric($topic)) {
                Topic::find($topic)->increment('questions_coount');
                return (int)$topic;
            }
            $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Question::find($id);

    }
}