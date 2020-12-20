
const path = require('path');
const fs = require('fs-extra');
const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
require('laravel-mix-bundle-analyzer');

function publishAssets() {
    const publicDir = path.resolve(__dirname, './public');

    if (mix.inProduction()) {
        fs.removeSync(path.join(publicDir, 'dist'));
    }

    fs.copySync(path.join(publicDir, 'build', 'dist'), path.join(publicDir, 'dist'));
    fs.removeSync(path.join(publicDir, 'build'));
}

mix.js('resources/js/app.js', 'public/dist/js')
    .sass('resources/sass/app.scss', 'public/dist/css')
    .options({
        postCss: [tailwindcss('./tailwind.config.js')],
        processCssUrls: false,
    });
// .disableNotifications()

if (mix.inProduction()) {
    // mix
    // // .extract() // Disabled until resolved: https://github.com/JeffreyWay/laravel-mix/issues/1889
    // // .version() // Use `laravel-mix-versionhash` for the generating correct Laravel Mix manifest file.
    //     .versionHash();
} else {
    mix.sourceMaps();
}

// use named JS bundles
// mix.config.webpackConfig.output = {
//     chunkFilename: 'js/[name].bundle.js',
//     publicPath: '/',
// };

// alias the ~/resources folder
mix.webpackConfig({
    plugins: [
        // new BundleAnalyzerPlugin()
    ],

    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '@': `${__dirname}/resources`,
            '~': path.join(__dirname, './resources/js'),
            ziggy: path.join(__dirname, './vendor/tightenco/ziggy/dist/js/route.js'),
        },
    },

    output: {
        chunkFilename: 'dist/js/[chunkhash].js',
        path: mix.config.hmr ? '/' : path.resolve(__dirname, './public/build'),
    },
});

mix.then(() => {
    if (!mix.config.hmr) {
        process.nextTick(() => publishAssets());
    }
});

// manually run analyzer at http://localhost:8888
// mix.bundleAnalyzer({
//     analyzerPort: 8888,
//     openAnalyzer: false,
// });
