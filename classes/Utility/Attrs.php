<?php
namespace Arkhe_Theme\Utility;

trait Attrs {

	/**
	 * htmlタグに付与する属性値
	 */
	public static function root_attrs() {

		$attrs = array(
			'data-loaded'      => 'false',
			'data-scrolled'    => 'false',
			'data-drawer'      => 'closed', // ドロワーメニューの状態
			'data-drawer-move' => 'fade', // ドロワーメニューの展開方法
			'data-sidebar'     => \Arkhe::is_show_sidebar() ? 'on' : 'off', // サイドバー
		);

		// フック通す
		$attrs = apply_filters( 'arkhe_root_attrs', $attrs );

		// 最終的に出力する文字列
		$attr_string = '';
		foreach ( $attrs as $key => $val ) {
			$attr_string .= " $key=\"$val\"";
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo trim( $attr_string );
	}


	/**
	 * ヘッダーの追加属性
	 */
	public static function header_attr( $args = null, $is_echo = true ) {

		$setting = \Arkhe::get_setting();
		$args    = array_merge( array(
			'show_drawer_sp' => $setting['show_drawer_sp'],
			'show_drawer_pc' => $setting['show_drawer_pc'],
			'show_search_sp' => $setting['show_search_sp'],
			'show_search_pc' => $setting['show_search_pc'],
			'btn_layout'     => 'l-r',
			'logo_pos'       => 'center',
		), $args );

		$attrs = array();

		// ロゴのポジション
		$attrs['data-logo'] = $args['logo_pos'];

		// ボタンレイアウト
		$attrs['data-btns'] = $args['btn_layout'];

		// ドロワーボタンの表示
		$data_has_drawer = '';
		if ( $args['show_drawer_sp'] && $args['show_drawer_pc'] ) {
			$data_has_drawer = 'both';
		} elseif ( $args['show_drawer_sp'] ) {
			$data_has_drawer = 'sp';
		} elseif ( $args['show_drawer_pc'] ) {
			$data_has_drawer = 'pc';
		}
		$attrs['data-has-drawer'] = $data_has_drawer;

		// サーチボタンの表示
		$data_has_search = '';
		if ( $args['show_search_sp'] && $args['show_search_pc'] ) {
			$data_has_search = 'both';
		} elseif ( $args['show_search_sp'] ) {
			$data_has_search = 'sp';
		} elseif ( $args['show_search_pc'] ) {
			$data_has_search = 'pc';
		}
		$attrs['data-has-search'] = $data_has_search;

		// 追従設定
		$setting = \Arkhe::get_setting();
		$pcfix   = $setting['fix_header_pc'] ? '1' : '0';
		$spfix   = $setting['fix_header_sp'] ? '1' : '0';

		$attrs['data-pcfix'] = $pcfix;
		$attrs['data-spfix'] = $spfix;

		// オーバーレイ化
		if ( \Arkhe::is_header_overlay() ) {
			$attrs['data-overlay'] = '1';
		}

		// フック通す
		$attrs = apply_filters( 'arkhe_header_attrs', $attrs );

		// 最終的に出力する文字列
		$attr_string = '';
		foreach ( $attrs as $key => $val ) {
			$attr_string .= " $key=\"$val\"";
		}

		// 出力するか、returnで返すか
		if ( $is_echo ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo trim( $attr_string );
		} else {
			return trim( $attr_string );
		}
	}


	/**
	 * l-main クラス
	 */
	public static function main_class() {

		$class = 'l-main';
		if ( is_front_page() && ! is_home() ) {
			$class .= ' l-article';
		} elseif ( is_page() || is_single() || is_404() ) {
			$class .= ' l-article';
		}

		$class = apply_filters( 'arkhe_main_class', $class );

		echo esc_attr( $class );
	}


	/**
	 * l-main__body クラス
	 */
	public static function main_body_class( $is_echo = true ) {

		$class = 'l-main__body';

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
