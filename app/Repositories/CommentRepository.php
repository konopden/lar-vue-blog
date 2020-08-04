<?php

namespace App\Repositories;

use App\Comment;

class CommentRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

    /**
     * @param $articleId
     * @return mixed
     */
    public function getByArticle($articleId)
    {
        return $this->model->where('article_id', $articleId)->where('status', true)->with('user')->get();
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
        return $this->model->where('id', $this->model->id)->with('user')->first();
    }

    /**
     * @param $request
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return mixed
     */
    public function pageWithRequest($request, $number = 10, $sort = 'desc', $sortColumn = 'id')
    {
        $keyword = $request->get('keyword');

        return $this->model
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('content', 'like', "%{$keyword}%");
            })
            ->whereHas('article', function ($q) {
                $q->where('deleted_at', '=', null);
            })
            ->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }
}
