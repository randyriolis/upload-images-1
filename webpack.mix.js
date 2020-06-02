const mix = require('laravel-mix');
const js = 'public/js/';
const css = 'public/css/';

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

if (mix.inProduction()) {
    mix.version();
}

mix.js('resources/js/app.js', js)
    .sass('resources/sass/app.scss', css);

// template sb admin 2
mix.js('resources/js/sb-admin-2.js', js)
    .sass('resources/sass/sb-admin-2/sb-admin-2.scss', css);

// category
mix.js('resources/js/dashboard/category/index.js', js + 'dashboard/category/')
    .js('resources/js/dashboard/category/show.js', js + 'dashboard/category/');

// album
mix.js('resources/js/dashboard/album/index.js', js + 'dashboard/album/')
    .js('resources/js/dashboard/album/show.js', js + 'dashboard/album/');

// folder
mix.js('resources/js/dashboard/folder/index.js', js + 'dashboard/folder/');

// regenerate
mix.js('resources/js/dashboard/regenerate/category.js', js + 'dashboard/regenerate/');
