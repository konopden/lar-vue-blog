<?php

namespace Tests\Browser\Pages;


class Login extends Page
{
    public function url()
    {
        return '/en/login';
    }

    /**
     * Submit the form with the given credentials.
     * @param $browser
     * @param $email
     * @param $password
     * @return void
     */
    public function submit($browser, $email, $password)
    {
        $browser->type('email', $email)
            ->type('password', $password)
            ->press('Login')
            ->pause(500);
    }
}
