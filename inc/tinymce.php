<?php
namespace Arkhe_Theme;

add_action( 'admin_init', '\Arkhe_Theme\add_mce_style' );
add_action( 'tiny_mce_before_init', '\Arkhe_Theme\mce_before_init' );


/**
 * TinyMCEのエディタ内CSS
 */
function add_mce_style() {
	$editor_style_path = array( ARKHE_THEME_URI . '/dist/css/editor.css?v=' . ARKHE_VER );
	add_editor_style( $editor_style_path );
}

/**
 * TinyMCE設定
 */
function mce_before_init( $mceInit ) {

	// 見出し4まで
	// $mceInit['block_formats'] = '段落=p; 見出し 2=h2; 見出し 3=h3; 見出し 4=h4;';

	// id など消させない
	$mceInit['valid_elements']          = '*[*]';
	$mceInit['extended_valid_elements'] = '*[*]';

	// styleや、divの中のdiv,span、spanの中のspanを消させない
	$mceInit['valid_children'] = '+body[style],+div[div|span],+span[span],+td[style]';

	// 空タグや、属性なしのタグとか消そうとしたりするのを停止。
	$mceInit['verify_html'] = false;

	// テキストエディタがぐしゃっとなるのを防ぐ
	$mceInit['indent'] = true;

	// テーブルリサイズの制御 (不本意に pxが付与されるのを防ぐ)
	$mceInit['table_resize_bars'] = false;
	$mceInit['object_resizing']   = 'img';

	// インライン出力するCSS
	$mceInit = \Arkhe_Theme\set_content_style( $mceInit );

	return $mceInit;
}


/**
 * インラインスタイルをセット
 */
function set_content_style( $mceInit ) {

	// Gutenberg か Classic を判別するのに使う
	global $current_screen;

	if ( ! isset( $current_screen ) ) return $mceInit;

	// content_styleがまだなければ空でセット
	if ( ! isset( $mceInit['content_style'] ) ) {
		$mceInit['content_style'] = '';
	}

	$is_gutenberg = method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor();

	// Classic Editor
	if ( ! $is_gutenberg ) {
		$add_styles                = \Arkhe::output_style( 'editor' );
		$add_styles                = str_replace( '\\', '', $add_styles );  // contentのバックスラッシュで変になってしまうのでtinymceは別途指定
		$add_styles                = preg_replace( '/(?:\n|\r|\r\n)/su', '', $add_styles );
		$add_styles                = str_replace( '"', "'", $add_styles );
		$mceInit['content_style'] .= $add_styles;
	}

	return $mceInit;
}
