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

		// wp_get_document_title() の条件分岐に合わせて post_type > term > author の順
		// ※ クエリオブジェクトの取得優先度は WP_Term > WP_Post_Type > WP_User
		if ( is_post_type_archive() ) {
			$data['title'] = post_type_archive_title( '', false );
			$data['type']  = 'pt_archive';

		} elseif ( is_category() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'category';

		} elseif ( is_tag() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tag';

		} elseif ( is_tax() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tax';

		} elseif ( is_author() ) {

			$obj = get_queried_object();
			if ( isset( $wp_obj->display_name ) ) {
				$data['title'] = $wp_obj->display_name;
				$data['type']  = 'author';
			}
		} elseif ( is_date() ) {
			// 日付アーカイブ

			// phpcs:disable WordPress.WP.I18n.MissingArgDomain
			if ( is_year() ) {
				$title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
			} elseif ( is_month() ) {
				$title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
			} elseif ( is_day() ) {
				$title = get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
			}
			// phpcs:enable WordPress.WP.I18n.MissingArgDomain

			$data['title'] = $title;
			$data['type']  = 'date';

		} elseif ( is_archive() ) {

			$data['title'] = 'Archives';
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
	 * ツールバー拡張用データ
	 */
	public static function get_toolbar_data( $key, $title = '' ) {
		if ( 'licence' === $key ) {
			$title = $title ?: __( 'Licence registration', 'arkhe' );
			$title = '<span class="ab-icon -arkhe">' . self::get_svg( 'arkhe-logo' ) . '</span><span class="ab-label">' . $title . '</span>';

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


	/**
	 * カスタム投稿タイプに紐付いたタクソノミーを一つだけ取得する
	 */
	public static function get_tax_of_post_type( $the_post_type = '' ) {
		$the_post_type = $the_post_type ?: get_post_type();
		$the_tax       = 'category';

		// カスタム投稿タイプの場合
		if ( 'post' !== $the_post_type ) {

			// キャッシュ取得
			$cache_key = 'tax_of_' . $the_post_type;
			$the_tax   = wp_cache_get( $cache_key, 'arkhe' ) ?: '';

			if ( ! $the_tax ) {
				// 投稿タイプに紐づいたタクソノミーを取得
				$tax_array = get_object_taxonomies( $the_post_type, 'names' );
				foreach ( $tax_array as $tax_name ) {
					// 投稿フォーマットは除いて1つ目を取得
					if ( 'post_format' !== $tax_name ) {
						$the_tax = $tax_name;
						break;
					}
				}
				wp_cache_set( $cache_key, $the_tax, 'arkhe' );
			}
		}

		return apply_filters( 'arkhe_get_tax_of_post_type', $the_tax, $the_post_type );
	}
}
