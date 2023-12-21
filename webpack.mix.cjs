
const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .styles([
      'resources/css/app.css'
   ], 'public/css/styles.css');
