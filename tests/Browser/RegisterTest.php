<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Tests\Browser\Pages\Home;
use Tests\Browser\Pages\Register;

class RegisterTest extends DuskTestCase
{

    public function setUp(): void
    {
        parent::setup();

        static::closeAll();
    }

    public function testRegisterWithValidData()
    {
        $this->browse(function ($browser) {
            $browser->visit(new Register)
                ->submit([
                    'name' => 'Test User',
                    'email' => 'test@test.com',
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ])
                ->assertPageIs(Home::class);
        });
    }

    public function testRegisterExistingUser()
    {
        $user = factory(User::class)->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Register)
                ->submit([
                    'name' => 'Test User',
                    'email' => $user->email,
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ])
                ->assertSee('The email has already been taken.');
        });
    }

}
