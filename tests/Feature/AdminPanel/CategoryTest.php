<?php

namespace Tests\Feature\AdminPanel;

use App\Category;
use App\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setup();
        $user = User::where('is_admin', 1)->where('deleted_at', null)->firstOrFail();
        $this->actingAs($user);
        Session::start();
        $this->withHeader('X-CSRF-TOKEN', csrf_token());
    }

    public function testShowsCategories()
    {
        $response = $this->get('/api/category');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'path', 'image_url', 'status', 'description', 'created_at']],
            'meta' => ['pagination' => []],
        ]);
    }

    public function testAddCategory()
    {
        $data = array(
            'name' => 'test',
            'path' => 'test',
            'description' => 'test description',
        );
        $response = $this->post(route('category.store', $data));

        $category = Category::where('name', 'test')->firstOrFail();
        if($category->id){
            $category->forceDelete();
        }

        $response->assertStatus(204);
    }

    public function testUpdateCategory()
    {
        $category = factory(Category::class)->create();
        $data = array(
            'name' => 'test',
            'path' => 'test',
            'description' => 'test description',
        );
        $response = $this->patch(route('category.update', $category->id), $data);

        $category->forceDelete();

        $response->assertStatus(204);
    }

    public function testDeleteCategory()
    {
        $category = factory(Category::class)->create();
        $response = $this->delete(route('category.destroy', $category->id));

        $category->forceDelete();

        $response->assertStatus(204);
    }

    public function testSearchCategory()
    {
        $category = factory(Category::class)->create();
        $response = $this->get(route('category.index', array('params' => $category->name)));

        $category->forceDelete();

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'path', 'image_url', 'status', 'description', 'created_at']],
            'meta' => ['pagination' => []],
        ]);
        $response->assertSeeText($category->name, $escaped = true);
    }
}
