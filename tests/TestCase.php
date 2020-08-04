<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function checkAllLinksAnPageReturn200($content){
        preg_match_all("#<a\s+href\=\"([^\"]+)\"[^>]*>#uis", $content, $links);
        foreach($links[1] as $link){
            if($trimLink = self::trimLink($link)){
                echo $trimLink.PHP_EOL;
                $response = $this->get($trimLink);
                $response->assertStatus(200);
            }
        }
    }

    static private function trimLink($link){
        $url = strtok($link, '#');
        return $url;
    }
}
