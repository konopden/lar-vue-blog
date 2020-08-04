<?php

namespace App\Http\Controllers\Api;

use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class TagController extends ApiController
{
    protected $tag;

    public function __construct(TagRepository $tag)
    {
        parent::__construct();
        $this->tag = $tag;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->response->collection($this->tag->pageWithRequest($request));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList()
    {
        return response()->json($this->tag->all());
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->tag->destroy($id);

        return $this->response->withNoContent();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $this->tag->store($data);

        return $this->response->withNoContent();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->tag->update($id, $data);

        return $this->response->withNoContent();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return $this->response->item($this->tag->getById($id));
    }
}
