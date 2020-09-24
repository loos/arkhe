<?php
namespace ARKHE_THEME\Customizer;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * $wp_customize->selective_refresh->add_partialのコールバックを集めたクラス
 */
class Partial {

	private function __construct() {}

	/**
	 * パンくず
	 */
	public static function breadcrumb() {
		ob_start();
		\ARKHE_THEME::get_parts( 'others/breadcrumb' );
		return ob_get_clean();
	}

}
