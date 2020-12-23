// const webpack = require('webpack');
const path = require('path');

module.exports = {
	mode: 'production',

	entry: {
		main: path.resolve(__dirname, 'src/js/main.js'),
	},
	output: {
		path: path.resolve(__dirname, 'dist/js'),
		filename: '[name].js',
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				// query: {
				//     presets: ['react', 'es2015']
				// },
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
							// plugins: [['@babel/plugin-transform-react-jsx']],
						},
					},
				],
			},
			// {
			// 	test: /\.scss/,
			// 	use: [
			// 		// linkタグに出力する機能
			// 		'style-loader',
			// 		{
			// 			// CSSをバンドルするための機能
			// 			loader: 'css-loader',
			// 			options: { url: false }, // CSS内のurl()メソッドの取り込みを禁止する
			// 			// sourceMap: false, // ソースマップの利用有無
			// 			// importLoaders: 2, //sass-loaderの読み込みに必要?
			// 		},
			// 		{
			// 			loader: 'sass-loader',
			// 			options: {
			// 				// ソースマップの利用有無
			// 				// sourceMap: false,
			// 			},
			// 		},
			// 	],
			// },
		],
	},
	resolve: {
		alias: {
			'@js': path.resolve(__dirname, 'src/js/'),
		},
	},
	performance: { hints: false },
};
