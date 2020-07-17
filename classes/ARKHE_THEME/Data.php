<?php
namespace ARKHE_THEME;

use \ARKHE_THEME\Data\Default_Data;
if ( ! defined( 'ABSPATH' ) ) exit;

class Data {

	private static $instance;

	/**
	 * テーマバージョン
	 */
	public static $arkhe_version = '';

	/**
	 * カスタマイザーの設定データ
	 */
	protected static $settings         = '';
	protected static $default_settings = '';

	/**
	 * 設定画面のデータ
	 */
	// protected static $options         = '';
	// protected static $default_options = '';

	// DB名
	const DB_NAME_CUSTOMIZER = 'arkhe_settings';
	// const DB_NAME_OPTIONS    = 'arkhe_options';


	// 外部からインスタンス化させない
	private function __construct() {}

	// init()
	public static function init() {

		if ( isset( self::$instance ) ) return;
		self::$instance = new Data();

		// テーマバージョンを取得
		self::$instance->get_theme_version();

		// テーマバージョンを定数化しておく(wp_enqueue_ のクエリ付与用)
		if ( ! defined( 'ARKHE_VERSION' ) ) {
			define( 'ARKHE_VERSION', ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? date_i18n( 'mdGis' ) : self::$arkhe_version );
		}

		// 設定データのデフォルト値をセット
		self::$instance->set_default();

		// 設定データのセット
		add_action( 'after_setup_theme', array( self::$instance, 'set_settings' ), 9 );
		if ( is_customize_preview() ) {
			// wp_loaded : カスタマイザーのデータが反映されるタイミング。
			add_action( 'wp_loaded', array( self::$instance, 'set_settings' ), 10 );
		}
	}


	/**
	 * SWELLバージョンをセット
	 */
	private static function get_theme_version() {
		$theme_data          = wp_get_theme( 'arkhe' );
		self::$arkhe_version = $theme_data->Version;
	}


	/**
	 * デフォルト値をセット
	 */
	private static function set_default() {

		// self::$default_options = Default_Data::options();
		self::$default_settings = Default_Data::settings();

	}

	/**
	 * [カスタマイザーのデータ] 初期セット
	 */
	public function set_settings() {
		$db_data        = get_option( self::DB_NAME_CUSTOMIZER ) ?: array();
		self::$settings = array_merge( self::$default_settings, $db_data );
	}

	/**
	 * [カスタマイザーのデータ] データを個別でセット
	 */
	public static function set_setting( $key = null, $val = '' ) {
		if (  null === $key ) return;
		self::$settings[ $key ] = $val;
	}

	/**
	 * [カスタマイザーのデータ] 取得
	 *   キーが指定されていればそれを、指定がなければ全てを返す。
	 */
	public static function get_setting( $key = null ) {
		if ( null !== $key ) {
			return self::$settings[ $key ] ?: '';
		}
		return self::$settings;
	}

	/**
	 * [カスタマイザーのデータ] デフォルト値の取得
	 *   キーが指定されていればそれを、指定がなければ全てを返す。（カスタマイザーから使われる。）
	 */
	public static function get_default_setting( $key = null ) {
		if ( null !== $key ) {
			return self::$default_settings[ $key ] ?: '';
		}
		return self::$default_settings;
	}


	/**
	 * [オプション設定のデータ] デフォルト値の取得
	 *   キーが指定されていればそれを、指定がなければ全てを返す。
	 */
	// public static function get_default_option( $key = null ) {
	// 	if ( null !== $key ) {
	// 		return self::$default_options[ $key ] ?: '';
	// 	}
	// 	return self::$default_options;
	// }

	/**
	 * [オプション設定のデータ] 初期セット
	 */
	// public function set_options() {
	// 	$db_data       = get_option( self::DB_NAME_OPTIONS ) ?: array();
	// 	self::$options = array_merge( self::$default_options, $db_data );
	// }

	/**
	 * [オプション設定のデータ] データを個別でセット
	 */
	// public static function set_option( $key = null, $val = '' ) {
	// 	if (  null === $key  ) return;
	// 	self::$options[ $key ] = $val;
	// }

	/**
	 * [オプション設定のデータ] 取得
	 *   キーが指定されていればそれを、指定がなければ全てを返す。
	 */
	// public static function get_option( $key = null ) {
	// 	if ( null !== $key ) {
	// 		return self::$options[ $key ] ?: '';
	// 	}
	// 	return self::$options;
	// }

}
