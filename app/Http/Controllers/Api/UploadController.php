<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Tools\FileManager;

class UploadController extends ApiController
{
    protected $manager;

    public function __construct()
    {
        parent::__construct();
        $this->manager = new FileManager();
    }

    /**
     * Response the folder info.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->manager->folderInfo($request->get('folder'));

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function createFolder(Request $request)
    {
        $folder = $request->get('folder');

        $data = $this->manager->createFolder($folder);

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFile(Request $request)
    {
        $result = array();
        $files = $request->file('files');

        foreach ($files as $key => $file) {
            $fileName = $request->get('names')[$key]
                ? $request->get('names')[$key]
                : $file->getClientOriginalName();
            $path = str_finish($request->get('folder'), '/');
            if ($this->manager->checkFile($path . $fileName)) {
                return $this->response->withBadRequest('This File exists.');
            }
            $result[] = $this->manager->store($file, $path, $fileName);
        }
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFolder(Request $request)
    {
        $delFolder = $request->get('del_folder');

        $data = $this->manager->deleteFolder($delFolder);

        if (!$data) {
            return $this->response->withForbidden('The directory must be empty to delete it.');
        }

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFile(Request $request)
    {
        $path = $request->get('del_file');

        $data = $this->manager->deleteFile($path);

        return $this->response->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rename(Request $request)
    {
        $path = $request->get('path');
        $newName = $request->get('new_name');

        $data = $this->manager->renameFolder($path, $newName);

        return $this->response->json($data);
    }
}
