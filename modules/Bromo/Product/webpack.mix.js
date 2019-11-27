const { mix } = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/popular-product.js', 'js/popular-product.js')
.sass( __dirname + '/Resources/assets/sass/popular-product.scss', 'css/popular-product.css');

if (mix.inProduction()) {
    mix.version();
}