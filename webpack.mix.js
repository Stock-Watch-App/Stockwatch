const mix = require('laravel-mix');
require('laravel-mix-purgecss');
const tailwindcss = require('tailwindcss')

// https://gist.github.com/manuelcoppotelli/667bfb999acbc63d63646c710edfaba8

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   // .purgeCss()
   .options({
      processCssUrls: false,
      postCss: [ tailwindcss('./tailwind.config.js') ],
   })

   if (mix.inProduction()) {
      mix.purgeCss()
         .version();
   }
