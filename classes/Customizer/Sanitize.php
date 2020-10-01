<?php
namespace Arkhe_Theme\Customizer;

/**
 * カスタマイザーで使用するサニタイズ関数たち
 */
class Sanitize {

	private function __construct() {}

	/**
	 * controlのtypeからサニタイズ関数の名前を取得
	 */
	public static function get_sanitize_name( $type ) {

		switch ( $type ) {
			case 'checkbox':
				return array( '\Arkhe_Theme\Customizer\Sanitize', 'checkbox' );
			case 'radio':
			case 'select':
				return array( '\Arkhe_Theme\Customizer\Sanitize', 'select' );
			case 'number':
				return array( '\Arkhe_Theme\Customizer\Sanitize', 'float' );
			case 'image':
				return array( '\Arkhe_Theme\Customizer\Sanitize', 'image' );
			case 'color':
				return 'sanitize_hex_color';
			default: // text | textarea
				return 'wp_kses_post';
		}
	}


	/**
	 * 数値 int
	 */
	public static function int( $input ) {
		return intval( $input );
	}


	/**
	 * 数値 float
	 */
	public static function float( $input ) {
		return floatval( $input );
	}


	/**
	 * チェックボックス用サニタイズ関数
	 */
	public static function checkbox( $checked ) {
		return ( ( isset( $checked ) && true === $checked ) ? true : false );
	}


	/**
	 * ラジオボタン & セレクトボックス用サニタイズ関数
	 */
	public static function select( $input, $setting ) {
		// $input = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}


	/**
	 * ファイルアップローダー（画像）
	 * WP_Customize_Image_Controlに対して使う。
	 */
	public static function image( $image, $setting ) {
		$mimes = array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif'          => 'image/gif',
			'png'          => 'image/png',
			'bmp'          => 'image/bmp',
			'tif|tiff'     => 'image/tiff',
			'ico'          => 'image/x-icon',
		);
		$file  = wp_check_filetype( $image, $mimes );
		return ( $file['ext'] ? $image : $setting->default );
	}


	/**
	 * 動画用
	 */
	public static function video( $video_id, $setting ) {
		$video_url = wp_get_attachment_url( $video_id );
		$mimes     = array(
			'mpg|mpeg' => 'video/mpeg',
			'mp4'      => 'video/mp4',
			'webm'     => 'video/webm',
			'mov|qt'   => 'video/quicktime',
			'avi'      => 'video/x-msvideo',
		);
		$file      = wp_check_filetype( $video_url, $mimes );
		return ( $file['ext'] ? $video_id : $setting->default );
	}

}
