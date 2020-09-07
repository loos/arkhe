<?php
use ARKHE_THEME\TinyMCE;
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', 'arkhe_hook__add_editor_style' );
add_action( 'tiny_mce_before_init', 'arkhe_hook__tiny_mce_before_init' );


/**
 * TinyMCEのエディタ内CSS
 */
function arkhe_hook__add_editor_style() {
	$editor_style_path = array( ARKHE_TMP_DIR_URI . '/dist/css/editor.css?v=' . ARKHE_VERSION );
	add_editor_style( $editor_style_path );
}

/**
 * TinyMCE設定
 */
function arkhe_hook__tiny_mce_before_init( $mceInit ) {

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
	$mceInit = TinyMce::set_content_style( $mceInit );

	return $mceInit;
}
