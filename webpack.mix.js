
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

mix.js('resources/js/app.js', 'public/dist/js').vue({ version: 2 })
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

// alias the ~/resources folder
mix.webpackConfig({
    plugins: [],

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
        path: mix.inProduction() ? '/' : path.resolve(__dirname, './public/build'),
    },
});

mix.then(() => {
    if (mix.inProduction()) {
        process.nextTick(() => publishAssets());
    }
});

// reduce main bundle size
// mix.extract([
//     'axios',
//     'buefy',
//     'sweetalert2',
//     'vee-validate',
//     'vue-meta',
//     'vue-router',
//     'vuex',
// ]);

// manually run analyzer at http://localhost:8888
// mix.bundleAnalyzer({
//     analyzerPort: 8888,
//     openAnalyzer: false,
// });
