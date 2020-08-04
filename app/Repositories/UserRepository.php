<?php

namespace App\Repositories;

use App\Scopes\StatusScope;
use App\User;

class UserRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param $userName
     * @return mixed
     */
    public function getByName($userName)
    {

        return $this->model
            ->where('name', $userName)
            ->firstOrFail();
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
     * @param $id
     * @param $photo
     * @return mixed
     */
    public function saveAvatar($id, $photo)
    {
        $user = $this->getById($id);

        $user->avatar = $photo;

        return $user->save();
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
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->orderBy($sortColumn, $sort)
            ->paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }

    /**
     * @param $input
     * @return User
     */
    public function store($input)
    {
        $this->model->fill($input);
        $this->model->save();
        return $this->model;
    }
}
