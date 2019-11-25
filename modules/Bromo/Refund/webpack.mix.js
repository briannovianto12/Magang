const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/refund-order.js', 'js/refund-order.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/refund.css');

if (mix.inProduction()) {
    mix.version();
}