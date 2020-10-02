<?php
namespace Arkhe_Theme\Utility;

trait Attrs {

	/**
	 * htmlタグに付与する属性値
	 */
	public static function root_attrs() {

		// スクロール制御
		$attrs = 'data-loaded="false"';

		$attrs .= ' data-scrolled="false"';

		// ドロワーメニューの形式
		$attrs .= ' data-drawer="closed"';

		// ドロワーメニューの形式
		$attrs .= ' data-drawer-move="fade"';

		// サイドバー
		$data_sidebar = \Arkhe::is_show_sidebar() ? 'on' : 'off';

		$attrs .= ' data-sidebar="' . $data_sidebar . '"';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo apply_filters( 'arkhe_root_attrs', $attrs );
	}


	/**
	 * ヘッダーの追加属性
	 */
	public static function header_attr( $args = null, $is_echo = true ) {
		$setting = \Arkhe::get_setting();

		$logo_pos = isset( $args['logo_pos'] ) ? $args['logo_pos'] : '';

		// 追従設定
		$pcfix = $setting['fix_header_pc'] ? '1' : '0';
		$spfix = $setting['fix_header_sp'] ? '1' : '0';

		$attrs = 'data-pcfix="' . $pcfix . '" data-spfix="' . $spfix . '"';

		// ロゴを中央表示するかどうか
		if ( 'center' === $logo_pos ) {
			$attrs .= ' data-logo-pos="center"';
		}

		// オーバーレイ化

		if ( \Arkhe::is_header_overlay() ) {
			// $header_class .= ' is-overlay';
			$attrs .= ' data-overlay="true"';
		}

		$attrs = apply_filters( 'arkhe_header_attr', $attrs );
		if ( $is_echo ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $attrs;
		} else {
			return $attrs;
		}
	}


	/**
	 * l-content__main クラス
	 */
	public static function main_class() {

		$class = 'l-content__main';
		if ( is_front_page() && ! is_home() ) {
			$class .= ' l-article';
		} elseif ( is_page() || is_single() || is_404() ) {
			$class .= ' l-article';
		}

		$class = apply_filters( 'arkhe_main_class', $class );

		echo esc_attr( $class );
	}


	/**
	 * l-content__main__body クラス
	 */
	public static function main_body_class( $is_echo = true ) {

		$class = 'l-content__main__body';

		if ( is_front_page() || is_home() ) {
			$class .= ' p-front';
		} elseif ( is_attachment() || is_single() ) {
			$class .= ' p-entry';
		} elseif ( is_page() ) {
			$class .= ' p-page';
		} elseif ( is_archive() || is_search() ) {
			$class .= ' p-archive';
		} elseif ( is_404() ) {
			$class .= ' p-404';
		}

		$class = apply_filters( 'arkhe_main_body_class', $class );

		if ( $is_echo ) {
			echo esc_attr( $class );
		} else {
			return $class;
		}
	}


	/**
	 * c-postContent クラス
	 */
	public static function post_content_class() {

		$class = 'c-postContent';

		if ( is_front_page() || is_home() ) {
			$class .= ' p-front__content';
		} elseif ( is_attachment() || is_single() ) {
			$class .= ' p-entry__content';
		} elseif ( is_page() ) {
			$class .= ' p-page__content';
		} elseif ( is_archive() || is_search() ) {
			$class .= ' p-archive__content';
		} elseif ( is_404() ) {
			$class .= ' p-404__content';
		}

		$class = apply_filters( 'arkhe_post_content_class', $class );

		echo esc_attr( $class );
	}
}
