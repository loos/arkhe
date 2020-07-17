<?php
namespace ARKHE_THEME;

if ( ! defined( 'ABSPATH' ) ) exit;

class Javascript {

	/**
	 * パンくずリストのデータを保持する変数
	 */
	public static $bread_json_data = array();


	/**
	 * フロント側に渡すグローバル変数
	 */
	public static function get_front_global_vars() {
		$SETTING = \ARKHE_THEME::get_setting();

		return array(
			// 'adminUrl' => admin_url(),
			// 'apiPath' => rest_url() .'wp/v2/',
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'ajaxNonce'   => wp_create_nonce( 'arkhe-addon-ajax-nonce' ),
			'isFixHeadPC' => $SETTING['fix_header_pc'],
			'isFixHeadSP' => $SETTING['fix_header_sp'],
		);
	}

	/**
	 * 管理画面側に渡すグローバル変数
	 */
	public static function get_admin_global_vars() {
		return array(
			'adminUrl'    => admin_url(),
			'apiPath'     => rest_url() . 'wp/v2/',
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'ajaxNonce'   => wp_create_nonce( 'arkhe-addon-ajax-nonce' ),
		);
	}

}
