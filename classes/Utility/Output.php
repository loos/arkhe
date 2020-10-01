<?php
namespace Arkhe_Theme\Utility;

use \Arkhe_Theme\Style;

if ( ! defined( 'ABSPATH' ) ) exit;

trait Output {

	/**
	 * フロント側に渡すグローバル変数を返す
	 */
	public static function get_front_global_vars() {
		$SETTING = \Arkhe_Theme::get_setting();

		return array(
			'isFixHeadPC' => $SETTING['fix_header_pc'],
			'isFixHeadSP' => $SETTING['fix_header_sp'],
		);
	}


	/**
	 * 設定で切り替わるスタイルの出力
	 */
	public static function output_style( $type = 'front' ) {

		// スタイルを生成
		if ( 'front' === $type ) {
			Style::set_common_style();
			Style::set_front_style();
		} elseif ( 'editor' === $type ) {
			Style::set_common_style();
		}

		$output_style = '';

		// 全サイズ共通スタイル
		$output_style .= ':root{' . Style::$root_styles['all'] . '}';
		$output_style .= Style::$styles['all'];

		// メディアクエリ付きスタイル
		$output_style .= Style::get_media_query_css( 'pc', 'min-width: 960px' );
		$output_style .= Style::get_media_query_css( 'sp', 'max-width: 959px' );
		$output_style .= Style::get_media_query_css( 'tab', 'min-width: 600px' );
		$output_style .= Style::get_media_query_css( 'mobile', 'max-width: 599px' );

		return $output_style;
	}
}
