<?php
namespace Arkhe_Theme\Utility;

if ( ! defined( 'ABSPATH' ) ) exit;

trait Javascript {

	/**
	 * フロント側に渡すグローバル変数
	 */
	public static function get_front_global_vars() {
		$SETTING = \Arkhe_Theme::get_setting();

		return array(
			'isFixHeadPC' => $SETTING['fix_header_pc'],
			'isFixHeadSP' => $SETTING['fix_header_sp'],
		);
	}

}
