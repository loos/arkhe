<?php
namespace Arkhe_Theme\Utility;

trait Get {

	/**
	 * 投稿のタームデータから必要なものを取得
	 */
	public static function get_the_terms_data( $post_id, $tax ) {

		$cache_key = "the_terms_data_{$post_id}_{$tax}";

		// キャッシュ取得
		$cache_data = wp_cache_get( $cache_key, 'arkhe' );
		if ( $cache_data ) return $cache_data;

		$data  = array();
		$terms = get_the_terms( $post_id, $tax );

		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$data[] = array(
					'id'   => $term->term_id,
					'slug' => $term->slug,
					'name' => $term->name,
					'url'  => get_term_link( $term ),
				);
			}
		}

		$data = apply_filters( 'arkhe_get_the_terms_data', $data );

		wp_cache_set( $cache_key, $data, 'arkhe' );
		return $data;
	}


	/**
	 * 投稿のタームデータから必要なものを取得
	 */
	public static function get_author_icon_data( $author_id ) {

		if ( ! $author_id ) return null;

		// cache
		$cache_key  = "post_author_icon_{$author_id}";
		$cache_data = wp_cache_get( $cache_key, 'arkhe' );
		if ( $cache_data ) return $cache_data;

		$author_data = get_userdata( $author_id );
		if ( empty( $author_data ) ) return;

		$data = array(
			'name'   => $author_data->display_name,
			'url'    => get_author_posts_url( $author_id ),
			'avatar' => get_avatar( $author_id, 24, '', '', array( 'class' => 'u-obf-cover' ) ),
		);
		$data = apply_filters( 'arkhe_get_author_icon_data', $data );

		wp_cache_set( $cache_key, $data, 'arkhe' );
		return $data;
	}


	/**
	 * アーカイブページのデータを取得
	 */
	public static function get_archive_data( $key = '' ) {

		// キャッシュ取得
		$cache_data = wp_cache_get( 'archive_data', 'arkhe' );
		if ( $cache_data ) {
			return $key ? $cache_data[ $key ] : $cache_data;
		}

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

		} elseif ( is_archive() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = '';

		}

		$data = apply_filters( 'arkhe_get_archive_data', $data );

		wp_cache_set( 'archive_data', $data, 'arkhe' );
		return $key ? $data[ $key ] : $data;
	}


	/**
	 * リストレイアウトのリストを取得
	 */
	public static function get_list_layouts( $targets = array() ) {

		$layouts = self::$list_layouts;

		// 一部だけ返す場合
		if ( ! empty( $targets ) ) {
			foreach ( $layouts as $key => $val ) {
				if ( ! in_array( $key, $targets, true ) ) {
					unset( $layouts[ $key ] );
				}
			}
		}

		return $layouts;
	}


	/**
	 * svgアイコン
	 */
	public static function get_svg_icon( $icon_name, $add_class = '' ) {

		$path     = '';
		$view_box = '0 0 24 24';

		switch ( $icon_name ) {
			case 'arkhe-logo':
				$view_box = '0 0 40 40';
				$path     = '<polygon points="34.96,1.89 14.29,22.56 14.29,20.34 14.33,20.29 21.09,13.53 19.31,13.53 30.73,2.11 30.95,1.89 "/><polygon points="26.58,13.32 26.58,15.1 16.12,25.55 15.85,25.82 18.08,25.82 38,5.9 38,1.89 "/><polygon points="38,12.95 25.44,25.51 26.89,25.51 26.89,38.11 2,38.11 2,13.22 14.29,13.22 14.29,11.5 23.9,1.89  27.9,1.89 27.69,2.11 27.69,2.11 14.29,15.51 14.29,14.71 3.49,14.71 3.49,36.61 25.4,36.61 25.4,25.55 25.13,25.82 22.9,25.82 23.17,25.55 26.57,22.14 26.57,20.36 38,8.94"/><polygon points="27.69,2.11 14.29,15.51 27.69,2.11"/><polygon points="32.18,25.82 38,20 38,15.99 28.17,25.82"/><polygon points="38,25.82 38,23.04 35.22,25.82"/><polygon points="20.86,1.89 20.64,2.11 14.29,8.46 14.29,4.46 16.85,1.89"/>';
				break;
			default:
				break;
		}

		$svg_class = 'ark-svg -' . $icon_name;

		// 追加クラス
		if ( $add_class ) $svg_class .= ' ' . $add_class;

		return '<svg class="' . esc_attr( $svg_class ) . '" width="24" height="24" viewBox="' . $view_box . '" version="1.1" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false">' . $path . '</svg>';

	}


	/**
	 * ツールバー拡張用データ
	 */
	public static function get_toolbar_data( $key, $title = '' ) {
		if ( 'licence' === $key ) {
			$title = $title ?: __( 'Licence registration', 'arkhe' );
			$title = '<span class="ab-icon -arkhe">' . self::get_svg_icon( 'arkhe-logo' ) . '</span><span class="ab-label">' . $title . '</span>';

			// arkheアイコン用CSS
			$style = '<style>' .
				'#wpadminbar .ab-icon.-arkhe {display: flex;align-items: center;box-sizing: border-box;height: 100%;}' .
				'.ab-icon.-arkhe svg { width: 20px !important; fill: currentColor; }' .
			'</style>';

			return array(
				'id'     => 'arkhe_licence_check',
				'meta'   => array( 'class' => 'arkhe-menu-licence' ),
				'title'  => $style . $title,
				'href'   => admin_url( 'themes.php?page=arkhe&tab=licence' ),
			);
		}
	}
}
