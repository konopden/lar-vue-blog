<?php

namespace Tests\Feature\AdminPanel;

use App\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileTest extends TestCase
{
    public function setUp(): void
    {
        parent::setup();
        $user = User::where('is_admin', 1)->where('deleted_at', null)->firstOrFail();
        $this->actingAs($user);
        Session::start();
        $this->withHeader('X-CSRF-TOKEN', csrf_token());
    }

    public function testShowsFiles()
    {
        $response = $this->get('/api/files');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'folder', 'folderName', 'breadcrumbs', 'subFolders', 'files'
        ]);
    }

    public function testUploadFile()
    {
        $file = UploadedFile::fake()->image('test.jpg');
        $response = $this->post('/api/files/upload', ['files' => [$file]]);

        Storage::disk()->assertExists('test.jpg');
        $response->assertJsonStructure([
            '*' => ['filename', 'fullPath', 'mime', 'modified', 'path', 'size', 'success', 'webPath']
        ]);

        Storage::disk()->delete('test.jpg');
    }

    public function testCreateFolder()
    {
        $this->post('/api/folder/create', ['folder' => '/testCreateFolder']);

        Storage::disk()->assertExists('/testCreateFolder');

        Storage::disk()->deleteDirectory('/testCreateFolder');
    }

    public function testRenameFolder()
    {
        Storage::disk()->makeDirectory('testCreateFolder');
        $this->post(
            '/api/files/rename',
            ['path' => '/testCreateFolder', 'new_name' => '/testCreateFolderRename']
        );
        Storage::disk()->assertExists('/testCreateFolderRename');

        Storage::disk()->deleteDirectory('/testCreateFolderRename');
    }

    public function testRenameFile()
    {
        Storage::disk()->put('testRenameFile.txt', 'Contents');
        $this->post(
            '/api/files/rename',
            ['path' => '/testRenameFile.txt', 'new_name' => '/testRenameFileNew.txt']
        );

        Storage::disk()->assertExists('/testRenameFileNew.txt');

        Storage::disk()->delete('/testRenameFileNew.txt');
    }

    public function testDeleteFile()
    {
        Storage::disk()->put('testDeleteFile.txt', 'Contents');
        $this->post(
            '/api/file/delete',
            ['del_file' => '/testDeleteFile.txt']
        );
        Storage::disk()->assertMissing('/testDeleteFile.txt');
    }

    public function testDeleteFolder()
    {
        Storage::disk()->makeDirectory('testDeleteFolder');
        $this->post(
            '/api/folder/delete',
            ['del_folder' => '/testDeleteFolder']
        );
        Storage::disk()->assertMissing('/testDeleteFolder');
    }

}
