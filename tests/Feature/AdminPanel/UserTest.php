<?php

namespace Tests\Feature\AdminPanel;

use App\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setup();
        $user = User::where('is_admin', 1)->where('deleted_at', null)->firstOrFail();
        $this->actingAs($user);
        Session::start();
        $this->withHeader('X-CSRF-TOKEN', csrf_token());
    }

    public function testShowsUsers()
    {
        $response = $this->get('/api/user');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'avatar', 'created_at', 'email']],
            'meta' => ['pagination' => []],
        ]);
    }

    public function testAddUser()
    {
        $data = array(
            'name' => 'user_test',
            'email' => 'test@mail.com' . rand(0, 1000),
            'info' => 'test',
            'password' => 'test0000',
            'password_confirmation' => 'test0000'
        );
        $response = $this->post(route('user.store', $data));

        $user = User::where('name', 'user_test')->firstOrFail();
        if($user->id){
            $user->forceDelete();
        }

        $response->assertStatus(200);
    }

    public function testUpdateUser()
    {
        $data = array(
            'name' => 'test' . rand(0, 1000),
            'email' => 'test@mail.com' . rand(0, 1000),
            'info' => 'test',
        );
        $user = factory(User::class)->create();
        $response = $this->patch(route('user.update', $user->id), $data);

        $user->forceDelete();

        $response->assertStatus(204);
    }

    public function testDeleteUser()
    {
        $user = factory(User::class)->create();
        $response = $this->delete(route('user.destroy', $user->id));

        $user->forceDelete();

        $response->assertStatus(200);
    }

    public function testSearchUser()
    {
        $user = factory(User::class)->create();
        $response = $this->get(route('user.index', array('params' => $user->name)));

        $user->forceDelete();

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'avatar', 'created_at', 'email']],
            'meta' => ['pagination' => []],
        ]);
        $response->assertSeeText($user->name, $escaped = true);
    }
}
