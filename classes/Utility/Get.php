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


	/**
	 * wp_get_attachment_image から必要な部分だけ抜き取った関数
	 */
	public static function get_image( $img_id, $args = array() ) {

		$echo = $args['echo'] ?? false;
		$size = $args['size'] ?? 'full';

		$html     = '';
		$noscript = '';
		$image    = wp_get_attachment_image_src( $img_id, $size, false );

		if ( ! $image ) return '';

		list( $src, $width, $height ) = $image;
		$size_array                   = array( absint( $width ), absint( $height ) );

		$width  = $args['width'] ?? $width;
		$height = $args['height'] ?? $height;

		// imgタグのattrs
		$attrs = array(
			'src'         => $src,
			'alt'         => $args['alt'] ?? wp_strip_all_tags( get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ),
			'class'       => $args['class'] ?? '',
			'srcset'      => $args['srcset'] ?? false,
			'sizes'       => $args['sizes'] ?? false,
			'style'       => $args['style'] ?? false,
			'decoding'    => $args['decoding'] ?? false,
			'aria-hidden' => $args['aria-hidden'] ?? false,
		);

		// 'srcset' と 'sizes' を生成
		if ( '' === $attrs['srcset'] ) {
			$attrs['srcset'] = false;
		} else {
			$image_meta = wp_get_attachment_metadata( $img_id );

			if ( is_array( $image_meta ) ) {
				// srcset の指定がなければ
				if ( ! $attrs['srcset'] ) {
					$attrs['srcset'] = wp_calculate_image_srcset( $size_array, $src, $image_meta, $img_id );
				}

				// sizes の指定がなければ (かつ、srcset があれば)
				if ( $attrs['srcset'] && ! $attrs['sizes'] ) {
					$attrs['sizes'] = wp_calculate_image_sizes( $size_array, $src, $image_meta, $img_id );
				}
			}
		}

		// lazyload種別
		$loading = $args['loading'] ?? Arkhe::get_lazy_type();
		if ( 'lazy' === $loading || 'eager' === $loading ) {
			$attrs['loading'] = $loading;

		} elseif ( self::is_rest() || self::is_iframe() ) {
			$attrs['loading'] = 'lazy';

		} elseif ( 'lazysizes' === $loading ) {
			$attrs['data-src'] = $attrs['src'];
			$attrs['src']      = $args['placeholder'] ?? ARKHE_PLACEHOLDER;
			if ( isset( $attrs['srcset'] ) ) {
				$attrs['data-srcset'] = $attrs['srcset'];
				unset( $attrs['srcset'] );
			}

			// noscript画像
			$noscript = '<noscript><img src="' . esc_attr( $src ) . '" class="' . esc_attr( $attrs['class'] ) . '" alt=""></noscript>';

			// lazyloadクラス追加はnoscript画像生成後に。(noscriptに 'lazyload'クラス は不要)
			$attrs['class'] .= ' lazyload';
			if ( $width && $height ) {
				$attrs['data-aspectratio'] = $width . '/' . $height;
			}
		}

		$img_props = image_hwstring( $width, $height );

		foreach ( $attrs as $name => $val ) {
			if ( false === $val ) continue;
			$img_props .= ' ' . $name . '="' . esc_attr( $val ) . '"';
		}

		$img = "<img $img_props >" . $noscript;

		if ( $echo ) {
			echo $img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		return $img;
	}
}
