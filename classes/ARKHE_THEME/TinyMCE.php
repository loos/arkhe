<?php
namespace ARKHE_THEME;

if ( ! defined( 'ABSPATH' ) ) exit;

class TinyMCE {

	private function __construct() {}

	/**
	 * インラインスタイルをセット
	 */
	public static function set_content_style( $mceInit ) {

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
			$add_styles                = \ARKHE_THEME\Style::output( 'editor' );
			$add_styles                = str_replace( '\\', '', $add_styles );  // contentのバックスラッシュで変になってしまうのでtinymceは別途指定
			$add_styles                = preg_replace( '/(?:\n|\r|\r\n)/su', '', $add_styles );
			$add_styles                = str_replace( '"', "'", $add_styles );
			$mceInit['content_style'] .= $add_styles;
		}

		return $mceInit;
	}

}
