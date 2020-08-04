<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Repositories\FeedbackRepository;

class ContactController extends Controller
{
    protected $feedback;

    public function __construct(FeedbackRepository $feedback)
    {
        $this->feedback = $feedback;
    }

    public function index()
    {
        return view('pages.contact');
    }

    /**
     * @param FeedbackRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(FeedbackRequest $request)
    {
        $feedback = $this->feedback->store($request->all());
        return response()->json($feedback, 200);
    }
}
