<?php
namespace App\Repositories;

trait BaseRepository
{
    /**
     * Get number of records
     *
     * @return array
     */
    public function getNumber()
    {
        return $this->model->count();
    }

    /**
     * @param $input
     * @return mixed
     */
    public function store($input)
    {
        return $this->save($this->model, $input);
    }

    /**
     * @param $model
     * @param $input
     * @return mixed
     */
    public function save($model, $input)
    {
        $model->fill($input);

        $model->save();

        return $model;
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
     * @param $id
     * @param $input
     * @return bool
     */
    public function update($id, $input)
    {
        $this->model = $this->model->findOrFail($id);

        $this->model->fill($input);
        $res =  $this->model->save();
        return $res;
    }
}
