const { mix } = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../../public').mergeManifest();


mix.js(__dirname + '/Resources/assets/js/app.js', 'js/transaction.js')
.sass( __dirname + '/Resources/assets/sass/app.scss', 'css/transaction.css')
.js(__dirname + '/Resources/assets/js/internal-notes.js', 'js/order-internal-notes.js');

if (mix.inProduction()) {
    mix.version();
}