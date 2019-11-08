const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.options({
    uglify: {
        uglifyOptions: {
              beautify: false,
              compress: false
        }
      }
})
mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/util.js', 'js/logistic.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/logistic.css');

if (mix.inProduction()) {
    mix.version();
}