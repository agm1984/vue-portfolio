const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
require('laravel-mix-bundle-analyzer');

// use named JS bundles
mix.config.webpackConfig.output = {
    chunkFilename: 'js/[name].bundle.js',
    publicPath: '/',
};

// alias the ~/resources folder
mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            '@': `${__dirname}/resources`,
        },
    },
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css').options({
        postCss: [tailwindcss('./tailwind.config.js')],
        processCssUrls: false,
    });

// manually run analyzer at http://localhost:8888
mix.bundleAnalyzer({
    analyzerPort: 8888,
    openAnalyzer: false,
});
