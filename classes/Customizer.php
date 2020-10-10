<?php
namespace Arkhe_Theme;

use \Arkhe_Theme\Customizer\Sanitize;
use \Arkhe_Theme\Customizer\Control\Base_Control;
use \Arkhe_Theme\Customizer\Control\Big_Title;
use \Arkhe_Theme\Customizer\Control\Sub_Title;
use \Arkhe_Theme\Customizer\Control\Color_Control;
use \Arkhe_Theme\Customizer\Control\Image_Control;
use \Arkhe_Theme\Customizer\Control\Media_Control;


/**
 * カスタマイザー
 */
class Customizer {

	private function __construct() {}

	/**
	 * デフォルト値とマージ
	 */
	public static function set_args( $args ) {

		$defaults = array(
			'classname'   => '',
			'label'       => '',
			'description' => '',
			'type'        => '',
			'mime_type'   => '',
			'choices'     => array(),
			'input_attrs' => array(),
			// 'sanitize' => '',
			'transport'   => 'refresh',
			'partial'     => array(),
			'db'          => \Arkhe::DB_NAMES['customizer'],
		);
		return array_merge( $defaults, $args );
	}


	/**
	 * 設定追加
	 * $customizer = $wp_customize
	 */
	public static function add( $section = '', $id = '', $args = array(), $Classname = '' ) {

		if ( '' === $id ) return;

		global $wp_customize;
		$customizer = $wp_customize;

		$args = self::set_args( $args );

		$customize_id = $args['db'] . '[' . $id . ']';
		$type         = $args['type'];
		$partial      = $args['partial'];

		// デフォルト値は args で指定されていなければ get_default_setting() で取得
		$default = isset( $args['default'] ) ? $args['default'] : \Arkhe::get_default_setting( $id );

		// setting 用
		$setting_args = array(
			'default'           => $default,
			'type'              => 'option',
			'transport'         => $args['transport'],
			'sanitize_callback' => isset( $args['sanitize'] ) ? $args['sanitize'] : Sanitize::get_sanitize_name( $type ),
		);

		// partialありの時、settingオプション追加
		if ( ! empty( $partial ) ) {
			$setting_args['transport'] = 'postMessage';
		}

		// add setting
		$customizer->add_setting( $customize_id, $setting_args );

		// control用
		$control_args = array(
			'label'       => $args['label'],
			'description' => $args['description'],
			'section'     => $section,
			'settings'    => $customize_id,
			'type'        => $type,
			'classname'   => $args['classname'],
		);

		$control_instance = null;

		// 追加処理
		if ( 'color' === $type ) {

			$control_instance = new Color_Control( $customizer, $customize_id, $control_args );

		} elseif ( 'image' === $type ) {

			$control_instance = new Image_Control( $customizer, $customize_id, $control_args );

		} elseif ( 'media' === $type ) {

			$control_args['mime_type'] = $args['mime_type'];
			$control_instance          = new Media_Control( $customizer, $customize_id, $control_args );

		} elseif ( 'radio' === $type || 'select' === $type ) {

			$control_args['choices'] = $args['choices'];

		} elseif ( 'number' === $type ) {

			$control_args['input_attrs'] = $args['input_attrs'];

		} elseif ( 'code_editor' === $type ) {

			$control_args['code_type'] = $args['code_type'];

		}

		// インスタンスまだなければ Base_Control で生成
		if ( null === $control_instance  ) $control_instance = new Base_Control( $customizer, $customize_id, $control_args );

		// add control
		$customizer->add_control( $control_instance );

		// add partial
		if ( ! empty( $partial ) ) {
			$customizer->selective_refresh->add_partial( $customize_id, $partial );
		}
	}


	/**
	 * カスタマイザーの大タイトル
	 * $customizer = $wp_customize
	 */
	public static function big_title( $section = '', $id = '', $args = array() ) {

		if ( '' === $id ) return;

		global $wp_customize;
		$customizer = $wp_customize;

		$args = self::set_args( $args );

		$control_args = array(
			'label'       => $args['label'],
			'description' => $args['description'],
			'section'     => $section,
			'classname'   => $args['classname'],
		);

		$customizer->add_setting( 'big_ttl_' . $id, array() );
		$customizer->add_control(
			new Big_Title( $customizer, 'big_ttl_' . $id . '', $control_args )
		);
	}

	/**
	 * カスタマイザーのサブタイトル
	 * $customizer = $wp_customize
	 */
	public static function sub_title( $section = '', $id = '', $args = array() ) {

		if ( '' === $id ) return;

		global $wp_customize;
		$customizer = $wp_customize;

		$args = self::set_args( $args );

		$control_args = array(
			'label'       => $args['label'],
			'description' => $args['description'],
			'section'     => $section,
			'classname'   => $args['classname'],
		);

		$customizer->add_setting( 'sub_ttl_' . $id, array() );
		$customizer->add_control(
			new Sub_Title( $customizer, 'sub_ttl_' . $id . '', $control_args )
		);
	}
}
