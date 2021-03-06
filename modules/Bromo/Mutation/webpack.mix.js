const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/mutation.js')
    .sass( __dirname + '/Resources/assets/sass/payment-detail.scss', 'css/mutation.css');

if (mix.inProduction()) {
    mix.version();
}