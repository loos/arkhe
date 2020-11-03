<?php
namespace Arkhe_Theme\Utility;

trait Parts {

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
			$thumb = '<img src="' . esc_url( ARKHE_NOIMG_URL ) . '" class="' . esc_attr( $class ) . '">';
		}

		// 通常のフロント表示の時（Gutenberg上やRESTの時以外）
		if ( ! defined( 'REST_REQUEST' ) ) {
			$placeholder = $placeholder ?: ARKHE_PLACEHOLDER;
			$thumb       = str_replace( ' src="', ' src="' . esc_url( $placeholder ) . '" data-src="', $thumb );
			$thumb       = str_replace( ' srcset="', ' data-srcset="', $thumb );
			// loading="lazy"
		}

		return $thumb;
	}


	/**
	 * タームリストを出力する
	 */
	public static function get_the_term_links( $post_id = '', $tax = '', $is_head = true ) {

		if ( 'cat' === $tax ) {
			$terms = get_the_category( $post_id );
			$icon  = 'arkhe-icon-folder';
		} elseif ( 'tag' === $tax ) {
			$terms = get_the_tags( $post_id );
			$icon  = 'arkhe-icon-tag';
		} else {
			$terms = get_the_terms( $post_id, $tax );
			$icon  = 'arkhe-icon-' . $tax;
		}

		if ( empty( $terms ) ) return '';

		// is_head なら リスト全体の前にアイコンを一つ
		$thelist = $is_head ? '<i class="c-postMetas__icon ' . esc_attr( $icon ) . '"></i>' : '';

		foreach ( $terms as $term ) {
			$term_link = get_term_link( $term );
			$thelist  .= '<a class="c-postTerms__link" href="' . esc_url( $term_link ) . '" data-' . sanitize_key( $tax ) . '-id="' . esc_attr( $term->term_id ) . '">' .
				esc_html( $term->name ) .
			'</a>';
		}

		return apply_filters( 'arkhe_get_the_term_links', $thelist, $post_id, $tax );
	}


	/**
	 * 日付を出力する
	 */
	public static function the_date_time( $date = null, $type = 'posted', $is_time = true ) {

		if ( null === $date ) return;

		$time_class = 'c-postTimes__item -' . $type . ' u-flex--aic';

		if ( $is_time ) {
			echo '<time class="' . esc_attr( $time_class ) . '" datetime="' . esc_attr( $date->format( 'Y-m-d' ) ) . '">' .
				'<i class="c-postMetas__icon arkhe-icon-' . esc_attr( $type ) . '" role="img" aria-hidden="true"></i>' .
				esc_html( $date->format( 'Y.m.d' ) ) .
			'</time>';
		} else {
			echo '<span class="' . esc_attr( $time_class ) . '">' .
				'<i class="c-postMetas__icon arkhe-icon-' . esc_attr( $type ) . '" role="img" aria-hidden="true"></i>' .
				esc_html( $date->format( 'Y.m.d' ) ) .
			'</span>';
		}
	}

}
