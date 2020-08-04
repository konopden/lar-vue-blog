<?php

namespace App\Http\Controllers;

use App\Repositories\TagRepository;


class TagController extends Controller
{
    protected $tag;

    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    public function index()
    {
        $tags = $this->tag->all();
        return view('pages.tags', compact('tags'));
    }

}
