<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;

class AdminController extends Controller
{
    protected $user;
    protected $article;
    protected $comment;

    public function __construct(
        UserRepository $user,
        ArticleRepository $article,
        CommentRepository $comment)
    {

        $this->user = $user;
        $this->article = $article;
        $this->comment = $comment;
    }

    public function index()
    {
        return view('admin-panel.index');
    }

    public function statistics()
    {
        $users = $this->user->getNumber();
        $articles = $this->article->getNumber();
        $comments = $this->comment->getNumber();

        $data = compact('users', 'articles', 'comments');

        return response()->json($data);
    }
}
