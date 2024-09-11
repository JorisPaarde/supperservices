const mix = require('laravel-mix');
const path = require('path');
const StylelintPlugin = require('stylelint-webpack-plugin');
const EslintPlugin = require('eslint-webpack-plugin');
const tailwindcss = require('tailwindcss');

mix.setPublicPath(path.resolve('./'))
    .ts('resources/js/app.ts', 'dist/js')
    .vue({ version: 3 })
    .sass('resources/scss/app.scss', 'dist/css')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss],
        terser: {
            extractComments: false,
            terserOptions: {
                output: {
                    comments: false,
                },
            },
        },
    })
    .extract()
    .alias({
        '@': path.join(__dirname, 'resources/js'),
    })
    .webpackConfig({
        devtool: mix.inProduction() ? 'source-map' : 'eval-source-map',
        plugins: [
            new StylelintPlugin({
                files: ['resources/**/*.?(vue|scss)'],
            }),
            new EslintPlugin({
                files: ['resources/**/*.?(vue|ts)'],
            }),
        ],
        resolve: {
            extensions: ['.js', '.ts', '.vue'],
        },
    });

if (mix.inProduction()) {
    mix.version();
}
