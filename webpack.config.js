var webpack = require('webpack');

module.exports = {
    debug: true,
    devtool : 'eval',

    entry: {
        app: './scripts/app.js'
    },

    output: {
        path: './dist/scripts/',
        filename: '[name].js'
    },

    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery'
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false
            }
        })
    ]
};