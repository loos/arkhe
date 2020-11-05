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
	public static $licence_data      = array();
	public static $has_pro_licence   = false;
	public static $licence_check_url = 'https://looscdn.com/cdn/arkhe/licence/check';

	/**
	 * プラグイン更新用パス
	 */
	public static $ex_update_path = false;


	/**
	 * 日本語かどうか
	 */
	public static $is_ja = false;


	/**
	 * テンプレートパーツまでのパス（子テーマ > this > 親テーマ）
	 */
	public static $ex_parts_path = '';


	/**
	 * パンくずリストのデータを保持する変数
	 */
	public static $bread_json_data = array();


	/**
	 * 一時的に抜粋分を変更するために変数化
	 */
	public static $excerpt_length = null;


	/**
	 * テキスト系HTMLを許可する時にwp_ksesに渡す配列
	 */
	public static $allowed_text_html = array(
		'a'      => array(
			'href'   => true,
			'rel'    => true,
			'target' => true,
			'class'  => true,
		),
		'b'      => array( 'class' => true ),
		'br'     => array( 'class' => true ),
		'i'      => array( 'class' => true ),
		'em'     => array( 'class' => true ),
		'span'   => array( 'class' => true ),
		'strong' => array( 'class' => true ),
	);


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

			$licence_data       = \Arkhe::get_licence_data( self::$licence_key );
			self::$licence_data = $licence_data;

			$status = (int) $licence_data['status'];

			// 有効なライセンスキーだった場合
			if ( 1 === $status || 2 === $status ) {
				self::$has_pro_licence = true;
				self::$ex_update_path  = isset( $licence_data['path'] ) ? $licence_data['path'] : '';
			}
}
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
