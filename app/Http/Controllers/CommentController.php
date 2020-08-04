<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    protected $comment;

    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
    }

    public function show($articleId)
    {
        $comments = $this->comment->getByArticle($articleId);

        return response()->json($comments, 200);
    }

    /**
     * Store a newly created comment in storage.
     *
     * @param  \App\Http\Requests\CommentRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(CommentRequest $request, $articleId)
    {
        $userId = Auth::id();
        $data = array_merge($request->all(), [
            'user_id' => ($userId) ? $userId : 1,
            'article_id' => $articleId
        ]);
        $comment = $this->comment->store($data);
        return response()->json($comment, 200);
    }

}
