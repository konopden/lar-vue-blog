<?php

namespace App\Repositories;

use App\Article;
use Carbon\Carbon;

class ArticleRepository
{
    use BaseRepository;

    protected $model;
    protected $visitor;

    public function __construct(Article $article, VisitorRepository $visitor)
    {
        $this->model = $article;
        $this->visitor = $visitor;
    }

    /**
     * Display articles.
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @param array $filter
     * @return mixed
     */
    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at', $filter = array())
    {
        if (!empty($filter['month']))
            $this->model = $this->model->whereMonth('published_at', Carbon::parse($filter['month'])->month);

        if (!empty($filter['year']))
            $this->model = $this->model->whereYear('published_at', $filter['year']);

        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @param $category
     * @return mixed
     */
    public function pageCategory($category, $number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->whereHas('category', function ($q) use ($category) {
            $q->where('path', '=', $category);
        })->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Get article by slug.
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {

        $article = $this->model
            ->where('slug', $slug)
            ->firstOrFail();

        $article->increment('view_count');

        $this->visitor->log($article->id);

        return $article;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function search($key)
    {
        $key = trim($key);

        return $this->model
            ->where('title', 'like', "%{$key}%")
            ->select('*')
            ->orderBy('published_at', 'desc')
            ->with('category')
            ->get();
    }

    /**
     * @param $tag
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return mixed
     */
    public function getByTag($tag, $number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->whereHas('tags', function ($q) use ($tag) {
            $q->where('tag', '=', $tag);
        })->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * @param $request
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return mixed
     */
    public function pageWithRequest($request, $number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $keyword = $request->get('keyword');

        return $this->model
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%");
            })
            ->orderBy($sortColumn, $sort)
            ->paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $tags
     */
    public function syncTag(array $tags)
    {
        $this->model->tags()->sync($tags);
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     */
    public function update($id, $input)
    {
        $this->model = $this->model->findOrFail($id);

        $this->model->fill($input);
        return $this->model->save();
    }
}
