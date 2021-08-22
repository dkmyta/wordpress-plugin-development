const path = require('path');

module.exports = {
    entry: './pdev.src.js',
	mode:  'development',

    output: {
        filename: 'pdev.build.js',
        path:     path.resolve(__dirname, '')
    },

    module: {
        rules: [
            {
                test:   /\.js$/,
                loader: 'babel-loader',
                query: {
                    presets: [
						'babel-preset-env',
						'babel-preset-react'
					]
                }
            }
        ]
    }
};