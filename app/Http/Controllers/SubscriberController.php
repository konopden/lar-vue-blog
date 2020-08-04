<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberRequest;
use App\Repositories\SubscriberRepository;

class SubscriberController extends Controller
{
    protected $subscriber;

    public function __construct(SubscriberRepository $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * @param SubscriberRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(SubscriberRequest $request)
    {
        $subscriber = $this->subscriber->store($request->all());
        return response()->json($subscriber, 200);
    }
}
