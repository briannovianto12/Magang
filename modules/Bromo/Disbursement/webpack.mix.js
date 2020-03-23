const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/disbursement.js')
    .js(__dirname + '/Resources/assets/js/disbursement.js', 'js/disbursement.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/disbursement.css');

if (mix.inProduction()) {
    mix.version();
}