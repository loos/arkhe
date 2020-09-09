const { src, dest } = require( 'gulp' );

// エラー時処理
const plumber = require( 'gulp-plumber' ); // 続行
const notify = require( 'gulp-notify' ); // 通知

// sass・css系
const sass = require( 'gulp-sass' ); // sassコンパイル
const sassGlob = require( 'gulp-sass-glob' ); // glob (@importの/*を可能に)
const autoprefixer = require( 'gulp-autoprefixer' ); // プレフィックス付与
const gcmq = require( 'gulp-group-css-media-queries' ); // media query整理
const cleanCSS = require( 'gulp-clean-css' );

// JS Concat
const babel = require( 'gulp-babel' );
const uglify = require( 'gulp-uglify' );
// const rename = require('gulp-rename');
// const concat = require('gulp-concat');

/**
 * パス
 */
const path = {
	src: {
		scss: 'src/scss/**/*.scss',
		// lazysizes: 'src/js/plugins/lazysizes/*.min.js',
		adminJs: 'src/js/admin/**/*.js',
		js: [ 'src/js/**/*.js', '!src/js/plugin/*js', '!src/js/admin/*js' ],
		block: 'src/block/**/*.js',
	},
	dest: {
		css: 'dist/css',
		js: 'dist/js',
	},
};

/**
 * SASSコンパイル
 */
const compileScss = ( cb ) => {
	return src( path.src.scss )
		.pipe( plumber( { errorHandler: notify.onError( '<%= error.message %>' ) } ) )
		.pipe( sassGlob() )
		.pipe( sass() )
		.pipe(
			autoprefixer( {
				cascade: false,
			} )
		)
		.pipe( gcmq() )
		.pipe( cleanCSS() )
		.pipe( dest( path.dest.css ) );
};

/*
 * プラグインスクリプトをまとめる
 */
// const concatPluginScripts = (cb) => {
// 	return src(path.src.lazysizes)
// 		.pipe(plumber({ errorHandler: notify.onError('<%= error.message %>') }))
// 		.pipe(concat('lazysizes.min.js'))
// 		.pipe(dest(path.dest.js + '/plugins/'));
// };

/**
 * Admin Script系の単純なminify化
 */
const minifyAdminJs = ( cb ) => {
	return src( path.src.adminJs )
		.pipe( plumber( { errorHandler: notify.onError( '<%= error.message %>' ) } ) )
		.pipe(
			babel( {
				presets: [ '@babel/preset-env' ],
			} )
		)
		.pipe( uglify() )
		.on( 'error', function ( e ) {
			/* eslint no-console: 0 */
			console.log( e );
		} )
		.pipe( dest( path.dest.js + '/admin' ) );
};

exports.compileScss = compileScss;
exports.minifyAdminJs = minifyAdminJs;
// exports.concatPlugins = concatPlugins;
