const path = require('path');

const resolve = path.resolve;
const adminDir = 'src/js/admin';

module.exports = {
	mode: 'production',

	entry: {
		'customizer-controls': resolve(__dirname, adminDir, 'customizer-controls.js'),
		'responsive-device-preview': resolve(__dirname, adminDir, 'responsive-device-preview.js'),
	},
	output: {
		path: resolve(__dirname, 'dist/js/admin'),
		filename: '[name].js',
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: [
					{
						// Babel を利用する
						loader: 'babel-loader',
						// Babel のオプションを指定する
						options: {
							presets: [
								[
									'@babel/preset-env',
									{
										modules: false,
										useBuiltIns: 'usage', //core-js@3から必要なpolyfillだけを読み込む
										corejs: 3,
										targets: {
											esmodules: true,
										},
									},
								],
							],
						},
					},
				],
			},
		],
	},
	performance: { hints: false },
};
