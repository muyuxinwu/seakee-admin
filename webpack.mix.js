let mix    = require('laravel-mix');
const path = require('path');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css', { implementation: require('node-sass') })
    .webpackConfig({
        resolve: {
            extensions: ['.js', '.vue', '.json'],
            alias     : {
                '@': path.resolve(__dirname, 'resources/assets/js')
            }
        },
        output: {
            // 未被列在 entry 且需要被打包出来的文件
            chunkFilename: 'js/[id].[hash].js'
        }
    })
    .options({
        uglify: {
            uglifyOptions: {
                sourceMap: false,
                compress : {
                    warnings    : false,
                    drop_console: true
                },
                output   : {
                    beautify: false
                }
            }
        }
    }).version();
