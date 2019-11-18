const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/tools.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/tools.css')
    .js(__dirname + '/Resources/assets/js/postal-code-finder.js', 'js/postal-code-finder.js')
    .js(__dirname + '/Resources/assets/js/shipping-simulation.js', 'js/shipping-simulation.js')
    .sass( __dirname + '/Resources/assets/sass/shipping-simulation.scss', 'css/shipping-simulation.css');

if (mix.inProduction()) {
    mix.version();
}