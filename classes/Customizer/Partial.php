<?php
namespace Arkhe_Theme\Customizer;

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
		\Arkhe::get_part( 'others/breadcrumb' );
		return ob_get_clean();
	}

}
