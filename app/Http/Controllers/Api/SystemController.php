<?php

namespace App\Http\Controllers\Api;


class SystemController extends ApiController
{
    public function index()
    {
        $serverInfo = array(
            'server' => $_SERVER['SERVER_SOFTWARE'],
            'http_host' => $_SERVER['HTTP_HOST'],
            'php' => phpversion(),
            'php_sapi_name' => php_sapi_name(),
            'extensions' => implode(", ", get_loaded_extensions()),
            'os' => PHP_OS,
            'articles_an_page' => config('settings.article.number'),
            'articles_sort' => config('settings.article.sortColumn').', '.config('settings.article.sort'),
            'image_cap' => config('settings.image_cap')

        );
        return response()->json($serverInfo);
    }
}
