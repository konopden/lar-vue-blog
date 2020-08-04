<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;

class SearchController extends Controller
{
    protected $article;

    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }


    public function search($lang, $search)
    {
        $key = trim($search);

        $articles = $this->article->search($key);

        return response()->json($articles, 200);
    }

}
