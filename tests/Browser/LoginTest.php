<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Tests\Browser\Pages\Home;
use Tests\Browser\Pages\Login;

class LoginTest extends DuskTestCase
{

    public function setUp(): void
    {
        parent::setup();

        static::closeAll();
    }

    public function testLoginWithValidCredentials()
    {
        $user = factory(User::class)->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Login)
                ->submit($user->email, 'password')
                ->assertPageIs(Home::class);
        });
    }

    public function testLoginWithInvalidCredentials()
    {
        $this->browse(function ($browser) {
            $browser->visit(new Login)
                ->submit('test@test.com', 'password')
                ->assertSee('These credentials do not match our records.');
        });
    }

    public function testLogout()
    {
        $user = factory(User::class)->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Login)
                ->submit($user->email, 'password')
                ->on(new Home)
                ->clickLogout()
                ->assertSee('Login / Register');
        });
    }
}
