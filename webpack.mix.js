const mix = require('laravel-mix');
// require('laravel-mix-purgecss');
// const tailwindcss = require('tailwindcss')

mix.js('resources/js/app.js', 'public/js')
   .less('resources/less/app.less', 'public/css')
   .less('resources/less/nova.less', 'public/css')
   // .purgeCss()
   // .options({
   //    processCssUrls: false,
   //    postCss: [ tailwindcss('./tailwind.config.js') ],
   // })

   // if (mix.inProduction()) {
   //    mix.purgeCss()
   //       .version();
   // }

mix.browserSync({
    proxy: process.env.MIX_BROWSER_SYNC_PROXY
});
