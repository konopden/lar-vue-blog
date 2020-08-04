<?php

namespace App\Tools;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Dflydev\ApacheMimeTypes\PhpRepository;
use Carbon\Carbon;

class FileManager
{
    protected $disk;

    /**
     * FileManager constructor.
     */
    public function __construct()
    {
        $this->disk = Storage::disk(config('filesystems.default', 'public'));
    }

    /**
     * @param UploadedFile $file
     * @param string $dir
     * @param string $name
     * @return array
     */
    public function store(UploadedFile $file, $dir = '', $name = '')
    {
        $hashName = empty($name)
            ? str_ireplace('.jpeg', '.jpg', $file->hashName())
            : $name;

        $mime = $file->getMimeType();

        $realPath = '/' . $this->disk->putFileAs($dir, $file, $hashName);

        return [
            'success' => true,
            'filename' => $hashName,
            'path' => $realPath,
            'fullPath' => "storage$realPath",
            'webPath' => $this->fileWebPath($realPath),
            'mime' => $mime,
            'size' => $this->fileSize($realPath),
            'modified' => $this->fileModified($realPath)
        ];
    }

    public function folderInfo($folder)
    {
        $folder = $this->cleanFolder($folder);

        $breadcrumbs = $this->breadcrumbs($folder);
        $slice = array_slice($breadcrumbs, -1);
        $folderName = current($slice);
        $breadcrumbs = array_slice($breadcrumbs, 0, -1);

        $subFolders = $this->getSubFolderList($folder);

        $files = $this->getFileList($folder);

        return compact([
            'folder',
            'folderName',
            'breadcrumbs',
            'subFolders',
            'files'
        ]);
    }

    /**
     * @param $folder
     * @return string
     */
    public function cleanFolder($folder)
    {
        return '/' . trim(str_replace('..', '', $folder), '/'); //eq: ../../test
    }

    /**
     * @param $folder
     * @return array
     */
    public function breadcrumbs($folder)
    {
        $folder = trim($folder, '/'); //eq: /test/2020/01/01/
        $crumbs = ['/' => 'root'];

        if (empty($folder)) return $crumbs;

        $folders = explode('/', $folder); // eq: ['test', '2020', '01', '01']
        $build = '';
        foreach ($folders as $folder) {
            $build .= '/' . $folder;
            $crumbs[$build] = $folder;
        }

        return $crumbs;
    }

    /**
     * @param $folder
     * @return array
     */
    public function getSubFolderList($folder)
    {
        $subFolders = [];
        foreach (array_unique($this->disk->directories($folder)) as $subFolder) {
            $subFolders[] = array(
                'name' => basename($subFolder),
                'path' => "/$subFolder"
            );
        }

        return $subFolders;
    }

    /**
     * @param $folder
     * @return array
     */
    public function getFileList($folder)
    {
        $files = [];

        $filesContent = $this->disk->files($folder);

        foreach ($filesContent as $file) {
            $files[] = $this->fileDetail($file);
        }

        return $files;
    }

    /**
     * @param $path
     * @return array
     */
    public function fileDetail($path)
    {
        $path = '/' . trim($path, '/');

        return [
            'filename' => basename($path),
            'path' => $path,
            'fullPath' => "/storage$path",
            'webPath' => $this->fileWebPath($path),
            'mime' => $this->fileMimeType($path),
            'size' => $this->fileSize($path),
            'modified' => $this->fileModified($path)
        ];
    }

    /**
     * @param $path
     * @return string
     */
    public function fileWebPath($path)
    {
        return asset("storage/" . ltrim($path, '/'));
    }

    /**
     * @param $path
     * @return mixed|string|null
     */
    public function fileMimeType($path)
    {
        return (new PhpRepository())->findType(
            pathinfo($path, PATHINFO_EXTENSION)
        );
    }

    /**
     * @param $path
     * @return string
     */
    public function fileSize($path)
    {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
        $bytes = $this->disk->size($path);

        $floor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.2f", $bytes / pow(1024, $floor)) . @$size[$floor];
    }

    /**
     * @param $path
     * @return string
     */
    public function fileModified($path)
    {
        return Carbon::createFromTimestamp(
            substr($this->disk->lastModified($path), 0, 10)
        )->toDateTimeString();
    }

    /**
     * @param $folder
     * @return bool
     * @throws \Exception
     */
    public function createFolder($folder)
    {
        $this->cleanFolder($folder);

        if ($this->checkFolder($folder)) {
            throw new \Exception("The Folder exists.");
        }

        return $this->disk->makeDirectory($folder);
    }

    /**
     * @param $folder
     * @return bool
     */
    public function checkFolder($folder)
    {
        return $this->disk->exists($folder);
    }

    /**
     * @param $path
     * @return bool
     */
    public function checkFile($path)
    {
        return $this->disk->exists($path);
    }

    /**
     * @param $path
     * @return bool
     */
    public function deleteFolder($path)
    {
        $this->cleanFolder($path);

        $filesFolders = array_merge(
            $this->disk->directories($path),
            $this->disk->files($path)
        );
        if (!empty($filesFolders)) {
            return false;
        }

        return $this->disk->deleteDirectory($path);
    }

    /**
     * @param $path
     * @return bool
     */
    public function deleteFile($path)
    {
        $this->cleanFolder($path);

        return $this->disk->delete($path);
    }

    public function renameFolder($path, $newFolderName){
        $this->cleanFolder($path);
        $pathFolders = array_slice(explode('/', $path), 1,-1);
        $pathFolders[] = $newFolderName;
        $newPath = '/'.implode('/', $pathFolders);
        if($newPath != $path)
            $this->disk->move($path, $newPath);
        return array('newPath' => $newPath, 'webPath' => $this->fileWebPath($newPath));
    }
}
