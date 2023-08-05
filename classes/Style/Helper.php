<?php
namespace Arkhe_Theme\Style;

trait Helper {

	/**
	 * :root スタイル生成
	 */
	public static function add_root_css( $name, $val, $media_query = 'all' ) {
		self::$root_styles[ $media_query ] .= $name . ':' . $val . ';';
	}


	/**
	 * インライン出力するスタイルを登録する
	 */
	public static function add_css( $selectors, $properties, $media_query = 'all', $branch = '' ) {

		if ( empty( $properties ) ) return;

		// セレクタの配列を分解して文字列へ
		if ( is_array( $selectors ) ) $selectors = implode( ',', $selectors );

		// プロパティの配列を分解して文字列へ
		if ( is_array( $properties ) ) $properties = implode( ';', $properties );

		// 出し分け
		if ( 'editor' === $branch ) {

			// 管理画面側でだけ出力
			if ( ! is_admin() ) return;

		} elseif ( 'front' === $branch ) {

			// フロント側でだけ出力
			if ( is_admin() ) return;

		}

		// メディアクエリごとに登録
		self::$styles[ $media_query ] .= $selectors . '{' . $properties . '}';
	}


	/**
	 * インライン出力するスタイルを登録する（フロントとエディターでそれぞれ親クラスを付与して出し分けるもの）
	 */
	public static function add_branch_css( $selectors, $properties, $media_query = 'all', $branch = 'both' ) {

		if ( empty( $properties ) ) return;
		if ( 'editor' === $branch && ! is_admin() ) return;
		if ( 'front' === $branch && is_admin() ) return;

		$new_selector = '';

		foreach ( $selectors as $s ) {
			if ( is_admin() ) {
				$new_selector .= '.mce-content-body ' . $s . ', .editor-styles-wrapper ' . $s;
			} else {
				$new_selector .= '.c-postContent ' . $s;
			}
			if ( end( $selectors ) !== $s ) {
				$new_selector .= ',';
			}
		}

		self::add_css( $new_selector, $properties, $media_query );
	}


	/**
	 * コンテンツ幅 （フロント & エディターで共通）
	 */
	protected static function set_content_width() {

		$container_width = \Arkhe::get_setting( 'container_width' );
		$slim_width      = \Arkhe::get_setting( 'slim_width' );

		// コンテナサイズ
		self::add_root_css( '--ark-width--container', $container_width . 'px' );
		self::add_root_css( '--ark-width--article', $container_width . 'px' );
		self::add_root_css( '--ark-width--article--slim', $slim_width . 'px' );

		// alignwide
		$plus_width = apply_filters( 'arkhe_alignwide_plus_width', 100 );
		self::add_root_css( '--ark-alignwide_ex_width', $plus_width . 'px' );

		if ( is_admin() ) {
			// 80: offset
			self::$styles['all'] .= '@container (max-width: ' . ( $container_width + ( $plus_width * 2 ) + 80 ) . 'px ) {' .
				'[data-align="wide"]{--ark-alignwide_ex_width:0px}' .
			'}';
		} else {
			// 基本 ( +4 で少しだけ余裕持たせてる ）
			self::$styles['all'] .= '@media (max-width: ' . ( $container_width + ( $plus_width * 2 ) + 4 ) . 'px ) {' .
				':root{--ark-alignwide_ex_width:0px}' .
			'}';

			// 1カラムページ（スリム）用
			self::$styles['all'] .= '@media (max-width: ' . ( $slim_width + ( $plus_width * 2 ) + 4 ) . 'px ) {' .
				':root{--ark-alignwide_ex_width:0px}' .
			'}';
		}
	}


	/**
	 * ブロックサイズ
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

		} elseif ( 'post' === $post_type ) {
			// 投稿ページのデフォルトはスリム幅。
			$block_width = $slim_width;

		} else {
			// 投稿以外のデフォルトテンプレート時 -> サイドバーの有無でサイズを決める
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

}
