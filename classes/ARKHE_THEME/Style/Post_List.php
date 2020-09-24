<?php namespace ARKHE_THEME\Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Post_List extends \ARKHE_THEME\Style {

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
	protected static function thumb_ratio( $card_ratio, $list_ratio ) {

		self::add_root(
			'--card_posts_thumb_ratio',
			self::get_thumb_ratio( $card_ratio )
		);
		self::add_root(
			'--list_posts_thumb_ratio',
			self::get_thumb_ratio( $list_ratio )
		);
	}

}
