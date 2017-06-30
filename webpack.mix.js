const {mix} = require('laravel-mix');

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

mix.browserSync('localhost/ProyectoFinal/public/');

mix//.js('resources/assets/js/app.js', 'public/js/vendor.js')
    .js(['resources/assets/js/app/app.js',
        'resources/assets/js/app/controllers/TestController.js',
        'resources/assets/js/app/controllers/NavController.js'], 'public/js/app.js')
    //.copyDirectory('resources/assets/js/app', 'public/js/app')
    .sass('resources/assets/sass/vendor.scss', 'public/css/vendor.css')
    .sass('resources/assets/sass/main.scss', 'public/css/app.css');
