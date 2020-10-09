<?php
namespace Arkhe_Theme\Utility;

trait Condition {

	/**
	 * 各ページでサイドバーを使用するかどうか
	 */
	public static function is_show_sidebar() {

		$template_slug = ( is_page() || is_single() ) ? basename( get_page_template_slug() ) : '';

		// テンプレート指定時は強制セット（フック通さない）
		if ( false !== strpos( $template_slug, 'one-column' ) ) {
			return false;
		} elseif ( 'two-column.php' === $template_slug ) {
			return true;
		}

		// デフォルトテンプレート時
		if ( is_search() || is_attachment() ) {

			$is_show_sidebar = false;

		} elseif ( is_front_page() ) {

			$is_show_sidebar = \Arkhe::get_setting( 'show_sidebar_top' );

		} elseif ( is_page() || is_home() ) {

			$is_show_sidebar = \Arkhe::get_setting( 'show_sidebar_page' );

		} elseif ( is_single() ) {

			$is_show_sidebar = \Arkhe::get_setting( 'show_sidebar_post' );

		} elseif ( is_archive() ) {

			$is_show_sidebar = \Arkhe::get_setting( 'show_sidebar_archive' );

		} else {

			$is_show_sidebar = false;

		}

		return apply_filters( 'arkhe_is_show_sidebar', $is_show_sidebar );
	}


	/**
	 * ヘッダーオーバーレイが有効化どうか
	 */
	public static function is_header_overlay() {
		$return            = false;
		$is_header_overlay = \Arkhe::get_setting( 'header_overlay' ) === 'on';

		if ( is_front_page() ) {
			$return = $is_header_overlay;
		} elseif ( is_page() || is_home() ) {
			$return = $is_header_overlay && \Arkhe::get_setting( 'header_overlay_on_page' );
		}

		return apply_filters( 'arkhe_is_header_overlay', $return );
	}


	/**
	 * ページタイトルをコンテンツ上部に表示するかどうか
	 */
	public static function is_show_ttltop() {

		if ( is_attachment() ) return false;

		if ( is_front_page() ) {
			$title_pos = '';
		} elseif ( is_page() || is_home() ) {
			$title_pos = \Arkhe::get_setting( 'page_title_pos' );
		} else {
			$title_pos = '';
		}

		$is_show_ttltop = ( 'top' === $title_pos ) ? true : false;
		return apply_filters( 'arkhe_is_show_ttltop', $is_show_ttltop );
	}


	/**
	 * パンくずリストの位置
	 */
	public static function get_breadcrumbs_position() {

		$breadcrumbs_pos = \Arkhe::get_setting( 'breadcrumbs_pos' );
		return apply_filters( 'arkhe_breadcrumbs_position', $breadcrumbs_pos );
	}

}
