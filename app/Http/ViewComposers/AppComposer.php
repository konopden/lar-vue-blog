<?php

namespace App\Http\ViewComposers;

use App\Category;
use App\Article;
use App\Tag;
use Illuminate\View\View;

class AppComposer
{
    public $categories;
    public $topArticles;
    public $tags;
    public $archives;

    public function __construct(Category $category, Article $article, Tag $tag)
    {
        $this->categories = $category->has('articles')->get()->sortByDesc('articles');
        $this->topArticles = $article->orderBy('view_count', 'desc')->take(3)->get();
        $this->tags = $tag->all();
        $this->archives = $article->selectRaw('year(published_at) year, monthname(published_at) month, count(*) published')
            ->groupBy('year', 'month')
            ->orderByRaw('min(published_at) desc')
            ->get();
        \Menu::makeOnce('mainMenu', function ($menu) {
            $menu->add(
                __('blog.homePage'),
                ['action' => ['ArticleController@index', 'locale' => app()->getLocale()]]
            );
            foreach ($this->categories as $category){
                $menu->add(
                    $category->name,
                    [
                        'action' =>
                            [
                                'ArticleController@indexCategory',
                                'locale' => app()->getLocale(), 'category' => $category->path
                            ]
                    ]
                );
            }
            $menu->add(
                __('blog.contactPage'),
                ['action' => ['ContactController@index', 'locale' => app()->getLocale()]]
            );
           $menu->add(
               __('blog.aboutPage'),
               ['action' => ['AboutController@index', 'locale' => app()->getLocale()]]
           );
        });
    }


    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->categories);
        $view->with('topArticles', $this->topArticles);
        $view->with('tags', $this->tags);
        $view->with('archives', $this->archives);
    }
}
