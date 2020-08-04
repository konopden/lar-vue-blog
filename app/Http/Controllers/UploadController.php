<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Tools\FileManager;

class UploadController extends Controller
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new FileManager();
    }

    public function fileUpload(ImageRequest $request){
        $strategy = $request->get('strategy', 'images');

        if (!$request->hasFile('image')) {
            return response()->json([
                'success' => false,
                'error' => 'no file found.',
            ]);
        }

        $path = $strategy . '/' . date('Y') . '/' . date('m') . '/' . date('d');

        $result = $this->manager->store($request->file('image'), $path);

        return response()->json($result);
    }
}
