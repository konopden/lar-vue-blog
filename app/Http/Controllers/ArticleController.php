<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;

class ArticleController extends Controller
{
    protected $article;

    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    public function index()
    {
        $articles = $this->article->page(
            config('settings.article.number'),
            config('settings.article.sort'),
            config('settings.article.sortColumn'),
            request(['month', 'year'])
        );
        return view('pages.main', compact('articles'));
    }

    public function indexCategory($lang, $category)
    {
        $articles = $this->article->pageCategory(
            $category,
            config('settings.article.number'),
            config('settings.article.sort'),
            config('settings.article.sortColumn')
        );

        if($category == 'fashion')
            return view('pages.fashion', compact('articles'));
        if($category == 'travel')
            return view('pages.travel', compact('articles'));
        if(!count($articles))
            abort(404);
        else
            return view('pages.main', compact('articles'));
    }

    public function show($lang, $category, $slug)
    {
        $article = $this->article->getBySlug($slug);

        if($article->category->path != $category)
            abort(404);

        return view('pages.article', compact('article'));
    }

    public function searchByTag($tag)
    {
        $articles = $this->article->getByTag($tag);
        return view('pages.main', compact('articles'));
    }
}
