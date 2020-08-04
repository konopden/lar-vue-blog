<?php

namespace Tests\Feature\AdminPanel;

use App\Article;
use App\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    protected $availableCategories;
    protected $availableTags;

    public function setUp(): void
    {
        parent::setup();
        $user = User::where('is_admin', 1)->where('deleted_at', null)->firstOrFail();
        $this->actingAs($user);
        $responseCategories = $this->get('/api/categories');
        $this->availableCategories = json_decode($responseCategories->getContent(), true);
        $responseTags = $this->get('/api/tags');
        $this->availableTags = json_decode($responseTags->getContent(), true);
        Session::start();
        $this->withHeader('X-CSRF-TOKEN', csrf_token());
    }

    public function testShowsArticles()
    {
        $response = $this->get('/api/article');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' =>
                [
                    'id', 'title', 'subtitle', 'user', 'slug', 'content', 'page_image',
                    'meta_description', 'is_original', 'is_draft', 'visitors', 'created_at',
                    'published_at', 'published_time'
                ]
            ],
            'meta' => ['pagination' => []],
        ]);
    }

    public function testAddArticle()
    {
        $data = array(
            'category_id' => $this->availableCategories[0]['id'],
            'title' => 'add_test',
            'subtitle' => 'test subtitle',
            'content' => 'test content',
            'tags' => json_encode([$this->availableTags[0]['id']]),
            'metaDesc' => 'meta test',
            'published_at' => '2000-01-01 00:00:00',
            'is_draft' => '1'
        );
        $response = $this->post(route('article.store', $data));

        $article = Article::where('title', 'add_test')->firstOrFail();
        if($article->id){
            $article->forceDelete();
        }

        $response->assertStatus(204);
    }

    public function testUpdateArticle()
    {
        $article = factory(Article::class)->create();
        $data = array(
            'category_id' => $this->availableCategories[0]['id'],
            'title' => 'test',
            'subtitle' => 'test subtitle',
            'content' => 'test content',
            'tags' => json_encode([$this->availableTags[0]['id']]),
            'metaDesc' => 'meta test',
            'published_at' => '2000-01-01 00:00:00',
            'is_draft' => '1'
        );
        $response = $this->patch(route('article.update', $article->id), $data);

        $article->forceDelete();

        $response->assertStatus(204);
    }

    public function testDeleteArticle()
    {
        $article = factory(Article::class)->create();
        $response = $this->delete(route('article.destroy', $article->id));

        $article->forceDelete();

        $response->assertStatus(204);
    }

    public function testSearchArticle()
    {
        $article = factory(Article::class)->create();
        $response = $this->get(route('article.index', array('params' => $article->title)));

        $article->forceDelete();

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' =>
                [
                    'id', 'title', 'subtitle', 'user', 'slug', 'content', 'page_image',
                    'meta_description', 'is_original', 'is_draft', 'visitors', 'created_at',
                    'published_at', 'published_time'
                ]
            ],
            'meta' => ['pagination' => []],
        ]);
        $response->assertSeeText($article->title, $escaped = true);
    }
}
