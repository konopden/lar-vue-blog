<?php

namespace Tests\Browser\Pages;

class Home extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/en';
    }


    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@navbarDropdown' => '#navbarDropdown'
        ];
    }

    public function clickLogout($browser)
    {
        $browser->click('@navbarDropdown')
            ->waitForText('Logout')
            ->clickLink('Logout')
            ->pause(100);
    }

}
