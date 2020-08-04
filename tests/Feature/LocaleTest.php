<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleTest extends TestCase
{

    public function testSetLocaleRu()
    {
        $response = $this->get('/ru');
        $this->assertEquals('ru', $this->app->getLocale());
    }

    public function testSetLocaleEn()
    {
        $response = $this->get('/en');
        $this->assertEquals('en', $this->app->getLocale());
    }
}
