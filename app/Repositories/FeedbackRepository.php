<?php

namespace App\Repositories;

use App\Feedback;

class FeedbackRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Feedback $feedback)
    {
        $this->model = $feedback;
    }

    /**
     * @param $input
     * @return bool
     */
    public function store($input)
    {
        $this->model->fill($input);
        return $this->model->save();
    }
}
