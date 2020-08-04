<?php

namespace Tests\Feature\AdminPanel;

use App\Tag;
use App\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TagTest extends TestCase
{
    public function setUp(): void
    {
        parent::setup();
        $user = User::where('is_admin', 1)->where('deleted_at', null)->firstOrFail();
        $this->actingAs($user);
        Session::start();
        $this->withHeader('X-CSRF-TOKEN', csrf_token());
    }

    public function testShowsTags()
    {
        $response = $this->get('/api/tag');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'tag', 'title', 'meta_description', 'status', 'created_at']],
            'meta' => ['pagination' => []],
        ]);
    }

    public function testAddTag()
    {
        $data = array(
            'tag' => 'add_test',
            'title' => 'test',
            'meta_description' => 'test description',
        );
        $response = $this->post(route('tag.store', $data));

        $tag = Tag::where('tag', 'add_test')->firstOrFail();
        if($tag->id){
            $tag->forceDelete();
        }

        $response->assertStatus(204);
    }

    public function testUpdateTag()
    {
        $tag = factory(Tag::class)->create();
        $data = array(
            'tag' => 'update_test',
            'title' => 'test',
            'meta_description' => 'test description',
        );
        $response = $this->patch(route('tag.update', $tag->id), $data);

        $tag->forceDelete();

        $response->assertStatus(204);
    }

    public function testDeleteTag()
    {
        $tag = factory(Tag::class)->create();
        $response = $this->delete(route('tag.destroy', $tag->id));

        $tag->forceDelete();

        $response->assertStatus(204);
    }

    public function testSearchTag()
    {
        $tag = factory(Tag::class)->create();
        $response = $this->get(route('tag.index', array('params' => $tag->tag)));

        $tag->forceDelete();

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'tag', 'title', 'meta_description', 'status', 'created_at']],
            'meta' => ['pagination' => []],
        ]);
        $response->assertSeeText($tag->tag, $escaped = true);
    }
}
