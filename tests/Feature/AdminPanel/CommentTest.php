<?php

namespace Tests\Feature\AdminPanel;

use App\Comment;
use App\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setup();
        $user = User::where('is_admin', 1)->where('deleted_at', null)->firstOrFail();
        $this->actingAs($user);
        Session::start();
        $this->withHeader('X-CSRF-TOKEN', csrf_token());
    }

    public function testShowsComment()
    {
        $response = $this->get('/api/comment');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'content', 'username', 'article_title', 'status', 'created_at']],
            'meta' => ['pagination' => []],
        ]);
    }

    public function testUpdateComment()
    {
        $comment = factory(Comment::class)->create();
        $data = array(
            'content' => 'test'
        );
        $response = $this->patch(route('comment.update', $comment->id), $data);

        $comment->forceDelete();

        $response->assertStatus(204);
    }

    public function testDeleteComment()
    {
        $comment = factory(Comment::class)->create();
        $response = $this->delete(route('comment.destroy', $comment->id));

        $comment->forceDelete();

        $response->assertStatus(204);
    }

    public function testSearchComment()
    {
        $comment = factory(Comment::class)->create();
        $response = $this->get(route('comment.index', array('params' => $comment->content)));

        $comment->forceDelete();

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'content', 'username', 'article_title', 'status', 'created_at']],
            'meta' => ['pagination' => []],
        ]);
        $response->assertSeeText($comment->content, $escaped = true);
    }

    public function testEnableComment()
    {
        $comment = factory(Comment::class)->create();
        $response = $this->post("/api/comment/$comment->id/status", array('status' => 1));
        $commentById = Comment::where('id', $comment->id)->firstOrFail();

        $this->assertEquals(1, $commentById->status);
        $response->assertStatus(204);

        $comment->forceDelete();
    }
}
