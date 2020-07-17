<?php namespace ARKHE_THEME\Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Post_List extends \ARKHE_THEME\Style {

	public static function get_thumb_ratio( $thumb_ratio ) {
		switch ( $thumb_ratio ) {
			case 'golden':
				return '61.8%';
			break;
			case 'silver':
				return '70.72%';
			break;
			case 'slr':
				return '66.66%';
			break;
			case 'wide':
				return '56.25%';
			break;
			case 'wide2':
				return '50%';
			break;
			case 'wide3':
				return '40%';
			break;
			default: // 'square'
				return '100%';
			break;
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
