<?php namespace Arkhe_Theme\Style;

if ( ! defined( 'ABSPATH' ) ) exit;

trait Post_List {

	/**
	 * 設定に合わせた比率を返す
	 */
	public static function get_thumb_ratio( $thumb_ratio ) {
		switch ( $thumb_ratio ) {
			case 'golden':
				return '61.8%';
			case 'silver':
				return '70.72%';
			case 'slr':
				return '66.66%';
			case 'wide':
				return '56.25%';
			case 'wide2':
				return '50%';
			case 'wide3':
				return '40%';
			default: // 'square'
				return '100%';
		}
	}


	/**
	 * サムネイル比率
	 */
	protected static function css_thumb_ratio( $card_ratio, $list_ratio ) {

		self::add_root_css(
			'--card_posts_thumb_ratio',
			self::get_thumb_ratio( $card_ratio )
		);
		self::add_root_css(
			'--list_posts_thumb_ratio',
			self::get_thumb_ratio( $list_ratio )
		);
	}

}
