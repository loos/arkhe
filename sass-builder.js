/* eslint no-console: 0 */
// console.log('start sass-builder.js ...');

const path = require( 'path' );
const fs = require( 'fs' );

// dart-sass（sass）。node-sass と違いネイティブバイナリを持たないため、Node のバージョンに依存しない。
const sass = require( 'sass' );
const globImporter = require( 'node-sass-glob-importer' );

// postcss
const postcss = require( 'postcss' );
const autoprefixer = require( 'autoprefixer' );
const cssnano = require( 'cssnano' );
const mqpacker = require( 'css-mqpacker' );

// consoleの色付け
const red = '\u001b[31m';
const green = '\u001b[32m';

const writeCSS = ( filePath, css ) => {
	const dir = path.dirname( filePath );

	// ディレクトリがなければ作成
	if ( ! fs.existsSync( dir ) ) {
		fs.mkdirSync( dir, { recursive: true } );
	}

	// css書き出し
	fs.writeFileSync( filePath, css );
};

// パス
const src = 'src/scss';
const dist = 'dist/css';
const files = [
	'icon',
	'main',
	'editor',
	'admin/menu',
	'admin/customizer',
	'admin/nav-menus',
	'admin/edit-table',
	'module/luminous',
	'module/-overlay-header',
];

files.forEach( ( fileName ) => {
	const filePath = path.resolve( __dirname, dist, `${ fileName }.css` );

	try {
		// dart-sass の legacy renderSync API でコンパイルする。
		// node-sass と異なり、dart-sass は renderSync でも importer（glob import の解決）を利用できる。
		const sassResult = sass.renderSync( {
			file: path.resolve( __dirname, src, `${ fileName }.scss` ),
			outputStyle: 'compressed',
			importer: globImporter(),
			// 既知の deprecation 警告を抑制する（Dart Sass 3.0 までは動作するため、移行は別途行う）。
			// - import        : @import の @use/@forward 移行（SCSS 全体の改修が必要）
			// - legacy-js-api : renderSync を modern compile API へ移行すれば解消できる
			// - color-functions / global-builtin : darken() 等を color.* / math.* 関数へ移行
			silenceDeprecations: [ 'import', 'legacy-js-api', 'color-functions', 'global-builtin' ],
		} );

		const css = sassResult.css.toString();

		// postcss実行
		postcss( [ autoprefixer, mqpacker, cssnano ] )
			.process( css, { from: undefined } )
			.then( ( postcssResult ) => {
				console.log( green + 'Wrote CSS to ' + filePath );
				writeCSS( filePath, postcssResult.css );

				// if (postcssResult.map) {fs.writeFile('dest/app.css.map', postcssResult.map.toString(), () => true);}
			} );
	} catch ( err ) {
		console.error( red + err );
	}
} );
