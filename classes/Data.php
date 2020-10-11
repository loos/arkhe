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
		'licence_key' => 'arkhe_licence_key',
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
	 * プラグインのデータ
	 */
	protected static $plugin_data = array();


	/**
	 * ライセンスキー
	 */
	public static $licence_key       = '';
	public static $licence_status    = '';
	public static $has_pro_licence   = false;
	public static $licence_check_url = 'https://looscdn.com/cdn/arkhe/check_licence/';

	/**
	 * プラグイン更新用パス
	 */
	public static $ex_update_path = false;


	/**
	 * 日本語かどうか
	 */
	public static $is_ja = false;


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

		// 日本語かどうか
		self::$is_ja = 'ja' === get_locale();

		// ライセンス情報をセット
		self::set_licence_data();

		// 設定データのデフォルト値をセット
		self::set_default_data();

		// 設定データのセット $GLOBALS['content_width'] のために after_setup_theme で取得。
		add_action( 'after_setup_theme', array( '\Arkhe_Theme\Data', 'set_settings_data' ), 9 );

		// カスタマイザーでは、データが即時反映されるタイミング（ wp_loaded ）で再セット
		if ( is_customize_preview() ) {
			add_action( 'wp_loaded', array( '\Arkhe_Theme\Data', 'set_settings_data' ) );
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
	 * ライセンス情報をセット
	 */
	private static function set_licence_data() {

		// ライセンスキー
		self::$licence_key = get_option( self::DB_NAMES['licence_key'] ) ?: '';

		// ライセンスキーの指定があれば、ステータスチェック
		if ( self::$licence_key ) {

			self::$licence_status = self::get_licence_status( self::$licence_key );

			// ステータスを配列に
			$status = json_decode( self::$licence_status, true );
			if ( ! is_array( $status ) || ! isset( $status['valid'] ) ) return;

			// ステータスを元に情報をセット
			self::$has_pro_licence = $status['valid'];
			if ( isset( $status['path'] ) ) {
				self::$ex_update_path = $status['path'];
			}
		}
	}

	/**
	 * ライセンスステータスを取得( キャッシュがあれば優先 )
	 *
	 * @return json
	 */
	private static function get_licence_status( $licence_key ) {

		$cache_key = 'arkhe_licence_status';

		$status = get_transient( $cache_key );
		if ( $status ) return $status;

		// ライセンスデータベースからチェック
		$status = \Arkhe::check_licence( self::$licence_key );
		set_transient( $cache_key, $status, DAY_IN_SECONDS ); // キャッシュ期間 : １日
		return $status;
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
	public static function get_setting( $key = '' ) {
		if ( $key ) {
			if ( ! isset( self::$settings[ $key ] ) ) return '';
			return self::$settings[ $key ] ?: '';
		}
		return self::$settings;
	}


	/**
	 * カスタマイザーのデフォルト値を取得
	 */
	public static function get_default_setting( $key = '' ) {
		if ( $key ) {
			if ( ! isset( self::$default_settings[ $key ] ) ) return '';
			return self::$default_settings[ $key ] ?: '';
		}
		return self::$default_settings;
	}


	/**
	 * カスタマイザーのデータを上書きするメソッド
	 */
	public static function overwrite_setting( $key = '', $val = '' ) {
		if ( ! $key ) return;
		self::$settings[ $key ] = $val;
	}


	/**
	 * プラグインのデータを取得
	 */
	public static function get_plugin_data( $key = '' ) {
		if ( $key ) {
			if ( ! isset( self::$plugin_data[ $key ] ) ) return '';
			return self::$plugin_data[ $key ] ?: '';
		}
		return self::$plugin_data;
	}


	/**
	 * プラグインのデータをセット
	 */
	public static function set_plugin_data( $key = '', $val = '' ) {
		if ( ! $key ) return;
		self::$plugin_data[ $key ] = $val;
	}

}
