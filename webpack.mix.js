const mix = require('laravel-mix');
require('laravel-mix-blade-reload');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/google-map.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/admin-panel.js', 'public/js')
    .sass('resources/sass/admin-panel.scss', 'public/css')
    .sass('resources/sass/admin-header.scss', 'public/css')
    .bladeReload();


mix.options({
    hmrOptions: {
        host: 'my-spa-laravel.localhost',
        port: 8080
    }
});

if (mix.inProduction()) {
    mix.version()
}
