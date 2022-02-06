const webpack = require( 'webpack' );
const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

/**
 * CleanWebpackPlugin （ビルド先のほかのファイルを勝手に削除するやつ） はオフに。
 */
defaultConfig.plugins.shift();

let entryFiles = {};
let srcDir = 'js';
let distDir = 'js';
if ( 'guten' === process.env.TYPE ) {
	srcDir = 'js/gutenberg';
	distDir = 'js/gutenberg';
	entryFiles = [ 'post_editor' ];
} else {
	// asset.php 出力しない
	for ( let i = 0; i < defaultConfig.plugins.length; i++ ) {
		const pluginInstance = defaultConfig.plugins[ i ];
		if ( 'DependencyExtractionWebpackPlugin' === pluginInstance.constructor.name ) {
			defaultConfig.plugins.splice( i, i );
		}
	}

	if ( 'front' === process.env.TYPE ) {
		entryFiles = [ 'main', 'plugin/lazysizes' ];
	} else if ( 'admin' === process.env.TYPE ) {
		srcDir = 'js/admin';
		distDir = 'js/admin';
		entryFiles = [ 'customizer-controls', 'responsive-device-preview' ];
	} else if ( 'guten' === process.env.TYPE ) {
		entryFiles = [ 'guten_post' ];
	}
}
const entryPoints = {};
entryFiles.forEach( ( name ) => {
	entryPoints[ name ] = path.resolve( './src', srcDir, `${ name }.js` );
} );

// ソースマップファイルを生成しない。
delete defaultConfig.devtool;

/**
 * exports
 */
module.exports = {
	...defaultConfig, //@wordpress/scriptを引き継ぐ

	mode: 'production', // より圧縮させる

	entry: entryPoints,

	output: {
		path: path.resolve( './dist', distDir ),
		filename: '[name].js',
	},

	resolve: {
		alias: {
			'@js': path.resolve( __dirname, 'src/js/' ),
		},
	},
	plugins: [ ...defaultConfig.plugins, new webpack.EnvironmentPlugin( [ 'TYPE' ] ) ],
	// performance: { hints: false },
	// devtool: 'none',
};
