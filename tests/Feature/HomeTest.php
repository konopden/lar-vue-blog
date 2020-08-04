<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * Check all links an page is correct.
     *
     * @return void
     */
    public function testAllLinksReturn200()
    {
        $response = $this->get('/en');
        $content = $response->getContent();
        $this->checkAllLinksAnPageReturn200($content);
    }
}
