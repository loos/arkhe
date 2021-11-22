/* eslint no-console: 0 */
// console.log('start sass-builder.js ...');

const path = require('path');
const fs = require('fs');

// node-sass
const sass = require('node-sass');
const nodeSassGlobbing = require('node-sass-globbing');

// postcss
const postcss = require('postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const mqpacker = require('css-mqpacker');

// consoleの色付け
const red = '\u001b[31m';
const green = '\u001b[32m';

const writeCSS = (filePath, css) => {
	const dir = path.dirname(filePath);

	// ディレクトリがなければ作成
	if (!fs.existsSync(dir)) {
		fs.mkdirSync(dir, { recursive: true });
	}

	// css書き出し
	fs.writeFileSync(filePath, css);
};

// パス
const src = 'src/scss';
const dist = 'dist/css';
const files = [
	'main',
	'editor',
	'admin/menu',
	'admin/customizer',
	'admin/nav-menus',
	'admin/edit-table',
	'module/-overlay-header',
];

files.forEach((fileName) => {
	// renderSyncだとimporter使えない
	sass.render(
		{
			file: path.resolve(__dirname, src, `${fileName}.scss`),
			outputStyle: 'compressed',
			importer: nodeSassGlobbing,
		},
		function (err, sassResult) {
			if (err) {
				console.error(red + err);
			} else {
				const css = sassResult.css.toString();
				const filePath = path.resolve(__dirname, dist, `${fileName}.css`);

				// postcss実行
				postcss([autoprefixer, mqpacker, cssnano])
					.process(css, { from: undefined })
					.then((postcssResult) => {
						console.log(green + 'Wrote CSS to ' + filePath);
						writeCSS(filePath, postcssResult.css);

						// if (postcssResult.map) {fs.writeFile('dest/app.css.map', postcssResult.map.toString(), () => true);}
					});
			}
		}
	);
});
