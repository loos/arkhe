<?php
namespace Arkhe_Theme\Utility;

use \Arkhe_Theme\Style;

trait Output {

	/**
	 * フロント側に渡すグローバル変数を返す
	 */
	public static function get_front_global_vars() {
		$setting = \Arkhe::get_setting();

		return array(
			'homeUrl'        => home_url( '/' ),
			'isFixHeadPC'    => $setting['fix_header_pc'],
			'isFixHeadSP'    => $setting['fix_header_sp'],
			'fixGnav'        => $setting['fix_gnav'],
			'smoothScroll'   => 'on',
		);
	}


	/**
	 * 設定で切り替わるスタイルの出力
	 */
	public static function output_style( $type = 'front' ) {

		// スタイルを生成
		new Style( $type );

		$output_style = '';

		// 全サイズ共通スタイル
		$output_style .= ':root{' . Style::$root_styles['all'] . '}';
		$output_style .= Style::$styles['all'];

		// メディアクエリ付きスタイル
		$output_style .= Style::get_media_query_css( 'pc', 'min-width: 960px' );
		$output_style .= Style::get_media_query_css( 'sp', 'max-width: 959px' );
		$output_style .= Style::get_media_query_css( 'tab', 'min-width: 600px' );
		$output_style .= Style::get_media_query_css( 'mobile', 'max-width: 599px' );

		// $output_style .= Style::$custom_styles

		return $output_style;
	}
}
