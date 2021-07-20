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
			'avatar' => get_avatar( $author_id, 24, '', '' ),
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

}
