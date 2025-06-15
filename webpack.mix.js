const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/chart-config.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
]);


mix.scripts(
    [
        "node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"

    ],
    "public/js/backend.js"
);


mix.sass("resources/sass/app.scss", "public/css/backend-theme.css");
// Backend CSS
mix.styles(
    [
        "public/css/backend-theme.css",
        "node_modules/@coreui/icons/css/all.css",
        "node_modules/@fortawesome/fontawesome-free/css/all.min.css"
    ],
    "public/css/backend.css"
);


mix.webpackConfig({
    resolve: {
        alias: {
            'jquery': path.resolve(__dirname, 'node_modules/jquery/dist/jquery.js')
        }
    }
});