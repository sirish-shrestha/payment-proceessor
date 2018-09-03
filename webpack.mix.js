let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

//COPY assets from resources folder to public folder
mix.copy('resources/assets/js/jquery-3.3.1.min.js', 'public/js/jquery.min.js', false);
mix.copy('resources/assets/js/bootstrap.min.js', 'public/js/bootstrap.min.js', false);
mix.copy('resources/assets/css/bootstrap.min.css', 'public/css/bootstrap.min.css', false);