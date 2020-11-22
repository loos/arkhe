<?php
namespace Arkhe_Theme\Style;

trait CSS {

	/**
	 * カラー変数のセット（フロント & エディターで共通のもの）
	 */
	protected static function css_common( $setting ) {
		self::add_root_css( '--ark-color_main', $setting['color_main'] );
		self::add_root_css( '--ark-color_text', $setting['color_text'] );
		self::add_root_css( '--ark-color_link', $setting['color_link'] );
		self::add_root_css( '--ark-color_bg', $setting['color_bg'] );
	}


	/**
	 * .alignwide の幅
	 */
	protected static function css_alignwide( $container_width, $slim_width ) {

		// 1カラムページ用
		self::$styles['all'] .= '@media (min-width: ' . ( $container_width + 160 + 96 ) . 'px ) {' .
			'[data-sidebar="off"] .alignwide{left:-80px;width:calc(100% + 160px)}' .
		'}';

		// 1カラムページ（スリム）用
		self::$styles['all'] .= '@media (min-width: ' . ( $slim_width + 160 + 96 ) . 'px ) {' .
			'.page-template-one-column-slim .alignwide{left:-80px;width:calc(100% + 160px)}' .
		'}';
	}


	/**
	 * コンテンツ幅
	 */
	protected static function css_content_width( $container_width, $slim_width ) {

		// コンテナサイズ
		self::add_root_css( '--ark-container_width', ( $container_width + 96 ) . 'px' );

		// 記事コンテンツサイズ
		self::add_root_css( '--ark-article_width', $container_width . 'px' );
		self::add_css(
			array( '.page-template-one-column-slim', '.post-template-one-column-slim' ),
			'--ark-article_width:' . $slim_width . 'px'
		);
	}


	/**
	 * コンテンツサイズ
	 */
	protected static function css_block_width( $container_width, $slim_width, $page_template ) {

		global $post_id; // 新規追加時は null
		global $post_type;

		$front_id = (int) get_option( 'page_on_front' );

		if ( 'one-column.php' === $page_template ) {
			// ワイド幅
			$block_width = $container_width;

		} elseif ( 'one-column-slim.php' === $page_template ) {
			// スリム幅
			$block_width = $slim_width;

		} elseif ( 'two-column.php' === $page_template ) {
			// 2カラム
			$block_width = 900;

		} else {
			// デフォルトテンプレート時はサイドバーの有無で判定
			if ( $front_id === $post_id ) {
				$side_key = 'show_sidebar_top';
			} elseif ( 'page' === $post_type ) {
				$side_key = 'show_sidebar_page';
			} else {
				$side_key = 'show_sidebar_post';
			}
			$block_width = \Arkhe::get_setting( $side_key ) ? 900 : $container_width;
		}

		// ブロック幅
		self::add_root_css( '--ark-block_width', $block_width . 'px' );
	}


	/**
	 * ヘッダー関連
	 */
	protected static function css_header( $logo_size_sp, $logo_size_pc ) {
		self::add_root_css( '--ark-logo_size_sp', $logo_size_sp . 'px' );
		self::add_root_css( '--ark-logo_size_pc', $logo_size_pc . 'px' );
	}


	/**
	 * タイトル背景
	 */
	protected static function css_title_bg( $ttlbg_overlay_color, $ttlbg_overlay_opacity ) {
		self::add_css(
			'.p-topArea.c-filterLayer::before',
			array(
				'background-color:' . $ttlbg_overlay_color,
				'opacity:' . $ttlbg_overlay_opacity,
			)
		);
	}


	/**
	 * 設定に合わせてサムネイル比率を返す
	 */
	public static function get_thumb_ratio( $thumb_ratio ) {
		switch ( $thumb_ratio ) {
			case 'golden':
				return '61.8%';
			case 'silver':
				return '70.72%';
			case 'slr':
				return '66.66%';
			case 'wide':
				return '56.25%';
			case 'wide2':
				return '50%';
			case 'wide3':
				return '40%';
			default: // 'square'
				return '100%';
		}
	}


	/**
	 * サムネイル比率
	 */
	protected static function css_thumb_ratio( $thumb_ratio ) {

		self::add_root_css(
			'--ark-thumb_ratio',
			self::get_thumb_ratio( $thumb_ratio )
		);
	}
}
