<?php
namespace Arkhe_Theme;

use \Arkhe_Theme\Data\Default_Data;

class Data {

	use \Arkhe_Theme\Data\Default_Data;

	/**
	 * DB名
	 */
	const DB_NAMES = array(
		'customizer'  => 'arkhe_settings',
	);


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
	 * パンくずリストのデータを保持する変数
	 */
	public static $bread_json_data = array();


	/**
	 * init()
	 */
	public static function init() {

		// テーマバージョンを取得
		self::set_theme_version();

		// テーマバージョンを定数化しておく(wp_enqueue_ のクエリ付与用)
		if ( ! defined( 'ARKHE_VER' ) ) {
			define( 'ARKHE_VER', ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? date_i18n( 'mdGis' ) : self::$arkhe_version );
		}

		// 設定データのデフォルト値をセット
		self::set_default_data();

		// 設定データのセット $GLOBALS['content_width'] のために after_setup_theme で取得。
		add_action( 'after_setup_theme', array( '\Arkhe_Theme\Data', 'set_settings_data' ), 9 );

		// カスタマイザーでは、データが即時反映されるタイミング（ wp_loaded ）で再セット
		if ( is_customize_preview() ) {
			add_action( 'wp_loaded', array( '\Arkhe_Theme\Data', 'set_settings_data' ), 10 );
		}
	}


	/**
	 * テーマバージョンをセット
	 */
	private static function set_theme_version() {
		$theme_data          = wp_get_theme( 'arkhe' );
		self::$arkhe_version = $theme_data->get( 'Version' );
	}


	/**
	 * デフォルト値を変数にセット
	 */
	private static function set_default_data() {

		self::$default_settings = self::get_default_settings();
	}


	/**
	 * カスタマイザーのデータを変数にセット
	 */
	public static function set_settings_data() {
		$db_data        = get_option( self::DB_NAMES['customizer'] ) ?: array();
		self::$settings = array_merge( self::$default_settings, $db_data );
	}


	/**
	 * カスタマイザーのデータを取得
	 */
	public static function get_setting( $key = null ) {
		if ( null !== $key ) {
			if ( ! isset( self::$settings[ $key ] ) ) return '';
			return self::$settings[ $key ] ?: '';
		}
		return self::$settings;
	}


	/**
	 * カスタマイザーのデフォルト値を取得
	 */
	public static function get_default_setting( $key = null ) {
		if ( null !== $key ) {
			if ( ! isset( self::$default_settings[ $key ] ) ) return '';
			return self::$default_settings[ $key ] ?: '';
		}
		return self::$default_settings;
	}


	/**
	 * カスタマイザーのデータを上書きするメソッド
	 */
	public static function overwrite_setting( $key = null, $val = '' ) {
		if (  null === $key ) return;
		self::$settings[ $key ] = $val;
	}

}
