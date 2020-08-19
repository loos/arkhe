<?php
use \ARKHE_THEME\Data;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ARKHE_THEME は 名前空間なしで定義
 */
class ARKHE_THEME {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		\ARKHE_THEME\Init::init();
	}

	/**
	 * Data 取得・セット系
	 */
	public static function get_setting( $key = null ) {
		return Data::get_setting( $key );
	}
	public static function set_setting( $key = null, $val = '' ) {
		Data::set_setting( $key, $val );
	}
	// public static function get_option( $key = null ) {
	// 	return Data::get_option( $key );
	// }
	// public static function set_option( $key = null, $val = '' ) {
	// 	Data::set_option( $key, $val );
	// }


	/**
	 * テンプレート読み込み
	 *   $path : 読み込むファイルのパス
	 *   $args : 引数として利用できるようにする変数
	 */
	public static function get_parts( $path = '', $args = null ) {

		if ( '' === $path ) return '';

		// まず子テーマ側から探す
		$include_path = ARKHE_STL_DIR . '/template-parts/' . $path . '.php';
		if ( ! file_exists( $include_path ) ) {

			// 次に、親テーマから探す
			$include_path = ARKHE_TMP_DIR . '/template-parts/' . $path . '.php';
			if ( ! file_exists( $include_path ) ) {
				// echo 'Include Error : "' . $path . '"';
				return '';
			}
		}

		$filter_name = 'arkhe_parts_' . str_replace( '/', '_', $path );
		if ( has_filter( $filter_name ) ) {
			// フィルターフックがあれば通す
			ob_start();
			include $include_path;

			// @codingStandardsIgnoreStart
			echo apply_filters( $filter_name, ob_get_clean(), $args );
			// @codingStandardsIgnoreEnd
		} else {

			// 普通にファイルを読み込むだけ
			include $include_path;

		}
		return '';
	}


	/**
	 * ファイル読み込み
	 */
	public static function get_file_contents( $file ) {

		if ( ! file_exists( $file ) ) return false;

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$creds = request_filesystem_credentials( '' );

		// WP_Filesystem 初期化
		if ( \WP_Filesystem( $creds ) ) {
			global $wp_filesystem;
			$file_content = $wp_filesystem->get_contents( $file );
			return $file_content;
		}

		// 	$file_content = file_get_contents( $file );
		// 	return $file_content;

		return false;
	}


	/**
	 * 各ページでサイドバーを使用するかどうか
	 */
	public static function is_show_sidebar() {

		if ( false !== strpos( ARKHE_PAGE_TEMPLATE, 'one-column' ) ) {

			$is_show_sidebar = false;

		} elseif ( 'two-column.php' === ARKHE_PAGE_TEMPLATE ) {

			$is_show_sidebar = true;

		} elseif ( is_search() || is_attachment() ) {

			$is_show_sidebar = false;

		} elseif ( is_front_page() ) {

			$is_show_sidebar = self::get_setting( 'show_sidebar_top' );

		} elseif ( is_page() || is_home() ) {

			$is_show_sidebar = self::get_setting( 'show_sidebar_page' );

		} elseif ( is_single() ) {

			$is_show_sidebar = self::get_setting( 'show_sidebar_post' );

		} elseif ( is_archive() ) {

			$is_show_sidebar = self::get_setting( 'show_sidebar_archive' );

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
		$is_header_overlay = self::get_setting( 'header_overlay' ) === 'on';

		if ( is_front_page() ) {
			$return = $is_header_overlay;
		} elseif ( is_page() || is_home() ) {
			$return = $is_header_overlay && self::get_setting( 'header_overlay_on_page' );
		}

		return apply_filters( 'arkhe_is_header_overlay', $return );
	}


	/**
	 * ページタイトルをコンテンツ上部に表示するかどうか
	 */
	public static function is_show_ttltop() {

		if ( is_front_page() ) return false;

		if ( is_attachment() ) return false;

		if ( is_page() || is_home() ) {
			$title_pos = self::get_setting( 'page_title_pos' );
		} else {
			$title_pos = '';
		}

		$is_show_ttltop = ( 'top' === $title_pos ) ? true : false;
		return apply_filters( 'arkhe_is_show_ttltop', $is_show_ttltop );
	}


	/**
	 * htmlタグに付与する属性値
	 */
	public static function root_attrs() {

		// $SETTING = ARKHE_THEME::get_setting();

		// スクロール制御
		$attrs = 'data-loaded="false"';

		$attrs .= ' data-scrolled="false"';

		// ドロワーメニューの形式
		$attrs .= ' data-drawer="closed"';

		// ドロワーメニューの形式
		$attrs .= ' data-drawer-move="fade"';

		// サイドバー
		$data_sidebar = self::is_show_sidebar() ? 'on' : 'off';

		$attrs .= ' data-sidebar="' . $data_sidebar . '"';

		// @codingStandardsIgnoreStart
		echo apply_filters( 'arkhe_root_attrs', $attrs );
		// @codingStandardsIgnoreEnd

	}

	/**
	 * ヘッダーの追加属性
	 */
	public static function header_attr( $args = null, $is_echo = true ) {
		$SETTING = self::get_setting();

		$logo_pos = isset( $args['logo_pos'] ) ? $args['logo_pos'] : '';

		// 追従設定
		$pcfix = $SETTING['fix_header_pc'] ? '1' : '0';
		$spfix = $SETTING['fix_header_sp'] ? '1' : '0';

		$attrs = 'data-pcfix="' . $pcfix . '" data-spfix="' . $spfix . '"';

		// ロゴを中央表示するかどうか
		if ( 'center' === $logo_pos ) {
			$attrs .= ' data-logo-pos="center"';
		}

		// オーバーレイ化

		if ( self::is_header_overlay() ) {
			// $header_class .= ' is-overlay';
			$attrs .= ' data-overlay="true"';
		}

		$attrs = apply_filters( 'arkhe_header_attr', $attrs );
		if ( $is_echo ) {
			// @codingStandardsIgnoreStart
			echo $attrs;
			// @codingStandardsIgnoreEnd
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


	/**
	 * アイキャッチ画像を取得
	 */
	public static function get_thumbnail( $post_id = null, $args = array() ) {
		$size        = isset( $args['size'] ) ? $args['size'] : 'full';
		$sizes       = isset( $args['sizes'] ) ? $args['sizes'] : '';
		$class       = isset( $args['class'] ) ? $args['class'] : '';
		$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';

		// memo : image_downsize( $img_id, 'medium' );
		$class           = $class . ' lazyload -no-lb';
		$attachment_args = array(
			'class' => $class,
			'alt'   => '',
		);

		$thumb = '';

		if ( has_post_thumbnail( $post_id ) ) {

			// アイキャッチ画像の設定がある場合
			$thumb = get_the_post_thumbnail( $post_id, $size, $attachment_args );

		} elseif ( ARKHE_NOIMG_ID ) {

			// まだサムネイル画像が取得できていない場合で、ARKHE_NOIMG_ID がある場合
			$thumb = wp_get_attachment_image( ARKHE_NOIMG_ID, $size, false, $attachment_args );
		}

		if ( $thumb ) {
			if ( $sizes ) {
				// 指定のサイズに書き換える
				$thumb = preg_replace( '/ sizes="([^"]*)"/', ' sizes="' . $sizes . '"', $thumb );
			}
		} else {
			$thumb = '<img src="' . ARKHE_NOIMG_URL . '" class="' . $class . '">';
		}

		// 通常のフロント表示の時（Gutenberg上やRESTの時以外）
		if ( ! defined( 'REST_REQUEST' ) ) {
			$placeholder = $placeholder ?: ARKHE_PLACEHOLDER;
			$thumb       = str_replace( ' src="', ' src="' . esc_attr( $placeholder ) . '" data-src="', $thumb );
			$thumb       = str_replace( ' srcset="', ' data-srcset="', $thumb );
			// loading="lazy"
		}

		return $thumb;
	}

	/**
	 * タームリストを出力する
	 */
	public static function get_the_term_links( $post_id = '', $tax = '' ) {

		if ( 'cat' === $tax ) {
			$terms = get_the_category( $post_id );
		} elseif ( 'tag' === $tax ) {
			$terms = get_the_tags( $post_id );
		} else {
			$terms = get_the_terms( $post_id, $tax );
		}

		if ( empty( $terms ) ) return '';

		$thelist = '';
		foreach ( $terms as $term ) {
			$term_link = get_term_link( $term );
			$data_id   = 'data-' . $tax . '-id="' . $term->term_id . '"';
			$thelist  .= '<a class="c-postMetas__link" href="' . esc_url( $term_link ) . '" ' . $data_id . '>' . $term->name . '</a>';
		}

		return apply_filters( 'arkhe_get_the_term_links', $thelist, $post_id, $tax );
	}

	/**
	 * 日付を出力する
	 */
	public static function the_date_time( $date = null, $type = 'posted', $is_time = true ) {

		if ( null === $date ) return;

		if ( $is_time ) {
			echo '<time class="c-postTimes__item -' . esc_attr( $type ) . '" datetime="' . esc_attr( $date->format( 'Y-m-d' ) ) . '">' .
				esc_html( $date->format( 'Y.m.d' ) ) .
			'</time>';
		} else {
			echo '<span class="c-postTimes__item -' . esc_attr( $type ) . '">' .
				esc_html( $date->format( 'Y.m.d' ) ) .
			'</span>';
		}

	}


	/**
	 * アーカイブページのデータを取得
	 * ['type'] : cayegory | tag | tax | etc...
	 * ['title'] : そのアーカイブページのタイトルとして表示する文字列
	 */
	public static function get_archive_data() {

		if ( ! is_archive() ) return false;

		$data = array(
			'type'  => '',
			'title' => '',
		);

		if ( is_date() ) {
			// 日付アーカイブなら

			$qv_day      = get_query_var( 'day' );
			$qv_monthnum = get_query_var( 'monthnum' );
			$qv_year     = get_query_var( 'year' );

			if ( 0 !== $qv_day ) {
				$ymd_name = $qv_year . '年' . $qv_monthnum . '月' . $qv_day . '日';
			} elseif ( 0 !== $qv_monthnum ) {
				$ymd_name = $qv_year . '年' . $qv_monthnum . '月';
			} else {
				$ymd_name = $qv_year . '年';
			}
			if ( is_post_type_archive() ) {
				// さらに、投稿タイプの日付アーカイブだった場合
				$data['title'] = $ymd_name . '(' . post_type_archive_title( '', false ) . ')';
			}
			$data['title'] = $ymd_name;
			$data['type']  = 'date';

		} elseif ( is_post_type_archive() ) {
			// 投稿タイプのアーカイブページなら

			$data['title'] = post_type_archive_title( '', false );
			$data['type']  = 'pt_archive';

		} elseif ( is_author() ) {
			// 投稿者アーカイブ

			$data['title'] = get_queried_object()->display_name;
			$data['type']  = 'author';

		} elseif ( is_category() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'category';

		} elseif ( is_tag() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tag';

		} elseif ( is_tax() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tax';

		} else {

			$data['title'] = single_term_title( '', false );
			$data['type']  = '';

		}

		return $data;
	}

}
