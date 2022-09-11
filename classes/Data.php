<?php
namespace Arkhe_Theme;

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
	 * データ通信先
	 */
	const CDN_URL = 'https://loos-cdn.com/arkhe';


	/**
	 * テーマバージョン
	 */
	public static $theme_ver = '';
	public static $file_ver  = '';


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
	 * lazyload種別
	 */
	protected static $lazy_type = 'lazy';


	/**
	 * ライセンス系
	 */
	public static $licence_key     = '';
	public static $licence_data    = array();
	public static $has_pro_licence = false;
	public static $ex_update_path  = false;


	/**
	 * 日本語かどうか
	 */
	public static $is_ja = false;


	/**
	 * リストレイアウト
	 */
	public static $list_layouts = array();


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
	 * 管理画面に表示するインフォメーション
	 */
	public static $arkhe_info = null;


	/**
	 * プレースホルダー画像
	 */
	public static $placeholder = 'data:image/gif;base64,R0lGODlhBgACAPAAAP///wAAACH5BAEAAAAALAAAAAAGAAIAAAIDhI9WADs=';


	/**
	 * JSの読み込みを制御する変数
	 */
	public static $use = array();


	/**
	 * テキスト系HTMLを許可する時にwp_ksesに渡す配列
	 */
	public static $allowed_img_html = array(
		'img' => array(
			'alt'     => true,
			'src'     => true,
			'secset'  => true,
			'class'   => true,
			'seizes'  => true,
			'width'   => true,
			'height'  => true,
			'loading' => true,
		),
	);


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
		'code'   => array( 'class' => true ),
		'span'   => array( 'class' => true ),
		'strong' => array( 'class' => true ),
		'ul'     => array( 'class' => true ),
		'ol'     => array( 'class' => true ),
		'li'     => array( 'class' => true ),
		'p'      => array( 'class' => true ),
		'div'    => array( 'class' => true ),
		'img'    => array(
			'alt'     => true,
			'src'     => true,
			'secset'  => true,
			'class'   => true,
			'seizes'  => true,
			'width'   => true,
			'height'  => true,
			'loading' => true,
		),
	);


	/**
	 * init()
	 */
	public static function init() {

		// セットアップ
		add_action( 'after_setup_theme', array( '\Arkhe_Theme\Data', 'setup__1' ), 1 );

		// 設定データのセット $GLOBALS['content_width'] のために after_setup_theme で取得。
		add_action( 'after_setup_theme', array( '\Arkhe_Theme\Data', 'set_settings_data' ), 9 );

		// カスタマイザーでは、データが即時反映されるタイミング（ wp_loaded ）で再セット
		if ( is_customize_preview() ) {
			add_action( 'wp_loaded', array( '\Arkhe_Theme\Data', 'set_settings_data' ) );
		}

		// フックで書き換えれる情報
		add_action( 'init', array( '\Arkhe_Theme\Data', 'setup__init20' ), 20 );

	}


	/**
	 * setup @after_setup_theme.1
	 */
	public static function setup__1() {

		// テーマバージョンを取得
		self::set_theme_version();

		// ライセンス情報をセット
		self::set_licence_data();

		// 設定データのデフォルト値をセット
		self::set_default_data();
	}


	/**
	 * setup　@init.20
	 */
	public static function setup__init20() {

		// 日本語かどうか
		self::$is_ja = 'ja' === get_locale();

		// レイアウト
		self::$list_layouts = apply_filters( 'arkhe_list_layouts', array(
			'card'   => __( 'Card type', 'arkhe' ),
			'list'   => __( 'List type', 'arkhe' ),
			'simple' => __( 'Text type', 'arkhe' ),
		) );

		// テーマインフォメーション取得
		if ( is_admin() ) self::set_theme_info();
	}


	/**
	 * テーマバージョンをセット
	 */
	private static function set_theme_version() {
		$theme_data      = wp_get_theme( 'arkhe' );
		self::$theme_ver = $theme_data->get( 'Version' );

		// ファイルにクエリとして付与するバージョン番号
		self::$file_ver = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? wp_date( 'mdGis' ) : self::$theme_ver;
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
	 * インフォメーション情報をセット
	 */
	private static function set_theme_info() {
		$json = get_transient( 'arkhe_informations' );
		if ( ! $json ) {
			$info_json = self::$is_ja ? 'information.json' : 'information_en.json';
			$response  = wp_remote_get( self::CDN_URL . '/' . $info_json );
			$json      = wp_remote_retrieve_body( $response );
			set_transient( 'arkhe_informations', $json, 7 * DAY_IN_SECONDS );
		}

		self::$arkhe_info = json_decode( $json, true );
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


	/**
	 * lazyload種別を取得
	 *
	 * @since 1.9
	 */
	public static function get_lazy_type() {
		return self::$lazy_type;
	}

	/**
	 * lazyload種別を上書き
	 *
	 * @since 1.9
	 */
	public static function set_lazy_type( $new_type ) {
		self::$lazy_type = $new_type;
	}


	/**
	 * $use の値を取得
	 *
	 * @since 1.9
	 */
	public static function is_use( $key ) {
		if ( ! isset( self::$use[ $key ] ) ) {
			return false;
		}
		return self::$use[ $key ];
	}


	/**
	 * $use の値を取得
	 *
	 * @since 1.9
	 */
	public static function set_use( $key, $val ) {
		self::$use[ $key ] = $val;
	}

}
