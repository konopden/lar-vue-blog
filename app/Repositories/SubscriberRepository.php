<?php

namespace App\Repositories;

use App\Subscriber;

class SubscriberRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Subscriber $subscriber)
    {
        $this->model = $subscriber;
    }

    /**
     * Store a new record.
     *
     * @param  $input
     * @return array
     */
    public function store($input)
    {
        $this->model->fill($input);
        $this->model->save();
        return $this->model->find($this->model->id);
    }
}
