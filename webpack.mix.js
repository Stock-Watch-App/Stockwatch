const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .less('resources/less/app.less', 'public/css')
   .less('resources/less/nova.less', 'public/css')

mix.browserSync({
    proxy: process.env.MIX_BROWSER_SYNC_PROXY
});
