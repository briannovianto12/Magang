const {mix} = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/popular-shop.js', 'js/popular-shop.js')
    .sass( __dirname + '/Resources/assets/sass/popular-shop.scss', 'css/popular-shop.css');;

if (mix.inProduction()) {
    mix.version();
}