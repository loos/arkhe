<?php
/**
 * プラガブル（上書き可能）な関数を定義
 */

/**
 * ロゴ画像の取得
 */
if ( ! function_exists( 'ark_get__head_logo_img' ) ) {
	function ark_get__head_logo_img( $logo_id ) {
		$return     = '';
		$logo_sizes = apply_filters( 'arkhe_head_logo_sizes', '(max-width: 999px) 50vw, 800px' );

		if ( ! Arkhe::is_header_overlay() ) {
			// 通常時

			$return = wp_get_attachment_image( $logo_id, 'full', false, array(
				'class' => 'c-headLogo__img',
				'sizes' => $logo_sizes,
				'alt'   => get_option( 'blogname' ),
			) );

		} else {
			// ヘッダーオーバーレイ有効時

			$ovrly_logo_id = Arkhe::get_setting( 'head_logo_overlay' ) ?: $logo_id;
			$ovrly_logo    = wp_get_attachment_image( $ovrly_logo_id, 'full', false, array(
				'class' => 'c-headLogo__img -top',
				'sizes' => $logo_sizes,
				'alt'   => get_option( 'blogname' ),
			) );

			$common_logo = wp_get_attachment_image( $logo_id, 'full', false, array(
				'class'   => 'c-headLogo__img -common',
				'sizes'   => $logo_sizes,
				'alt'     => '',
				'loading' => 'lazy',
			) );
			$common_logo = str_replace( '<img ', '<img aria-hidden="true" ', $common_logo );

			$return = $ovrly_logo . $common_logo;
		}
		return apply_filters( 'ark_get__head_logo_img', $return, $logo_id );
	}
}


/**
 * キャッチフレーズの出力
 */
if ( ! function_exists( 'ark_the__tagline' ) ) {
	function ark_the__tagline( $add_class = '' ) {
		$return = '<div class="' . esc_attr( trim( 'c-tagline ' . $add_class ) ) . '">' .
			esc_html( get_option( 'blogdescription' ) ) .
		'</div>';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo apply_filters( 'ark_the__tagline', $return, $args );
	}
}


/**
 * アイキャッチ画像を取得
 */
if ( ! function_exists( 'ark_the__thumbnail' ) ) {
	function ark_the__thumbnail( $args ) {
		$the_id           = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
		$size             = isset( $args['size'] ) ? $args['size'] : 'full';
		$sizes            = isset( $args['sizes'] ) ? $args['sizes'] : '';
		$class            = isset( $args['class'] ) ? $args['class'] : '';
		$placeholder      = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
		$placeholder_size = isset( $args['placeholder_size'] ) ? $args['placeholder_size'] : '';
		$use_lazyload     = isset( $args['use_lazyload'] ) ? $args['use_lazyload'] : true;

		// memo : image_downsize( $img_id, 'medium' );
		$attachment_args = array(
			'class' => $class,
		);

		$thumb = '';

		if ( has_post_thumbnail( $the_id ) ) {
			// アイキャッチ画像の設定がある場合

			$thumb = get_the_post_thumbnail( $the_id, $size, $attachment_args );
			if ( $placeholder_size ) {
				$placeholder = get_the_post_thumbnail_url( $the_id, $placeholder_size );
			}
		} elseif ( ARKHE_NOIMG_ID ) {
			// ARKHE_NOIMG_ID がある場合

			$thumb = wp_get_attachment_image( ARKHE_NOIMG_ID, $size, false, $attachment_args );
			if ( $placeholder_size ) {
				$placeholder = wp_get_attachment_image_url( ARKHE_NOIMG_ID, $placeholder_size ) ?: '';
			}
		} else {
			$thumb = '<img src="' . esc_url( ARKHE_NOIMG_URL ) . '" class="' . esc_attr( $class ) . '">';
		}

		// 指定のサイズがあれば書き換える
		if ( $sizes ) {
			$thumb = preg_replace( '/ sizes="([^"]*)"/', ' sizes="' . $sizes . '"', $thumb );
		}

		// 通常のフロント表示の時（Gutenberg上やRESTの時以外）
		if ( $use_lazyload && ! Arkhe::is_rest() && ! Arkhe::is_iframe() ) {
			$placeholder = $placeholder ? esc_url( $placeholder ) : ARKHE_PLACEHOLDER;
			$thumb       = str_replace( ' src="', ' src="' . $placeholder . '" data-src="', $thumb );
			$thumb       = str_replace( ' srcset="', ' data-srcset="', $thumb );
			$thumb       = str_replace( ' class="', ' class="lazyload ', $thumb );
			// loading="lazy"
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo apply_filters( 'ark_the__thumbnail', $thumb, $args );
	}
}


/**
 * 投稿の日付データを出力 (アーカイブと投稿ページで使用)
 * date: DateTime object
 */
if ( ! function_exists( 'ark_the__postdate' ) ) {
	function ark_the__postdate( $date = null, $type = 'posted' ) {

		if ( null === $date ) return;

		$date_format = get_option( 'date_format' );
		$icon_class  = 'c-postMetas__icon arkhe-icon-' . $type;
		$time_class  = 'c-postTimes__item u-flex--aic -' . $type;

		$return = '<time class="' . esc_attr( $time_class ) . '" datetime="' . esc_attr( $date->format( 'Y-m-d' ) ) . '">' .
			'<i class="' . esc_attr( $icon_class ) . '" role="img" aria-hidden="true"></i>' .
			esc_html( $date->format( $date_format ) ) .
		'</time>';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo apply_filters( 'ark_the__postdate', $return, $date, $type );
	}
}


/**
 * 前後記事リンク
 */
if ( ! function_exists( 'ark_the__pnlink' ) ) {
	function ark_the__pnlink( $args ) {
		$id    = isset( $args['id'] ) ? $args['id'] : 0;
		$type  = isset( $args['type'] ) ? $args['type'] : '';
		$title = isset( $args['title'] ) ? $args['title'] : '';

		$return = '<a href="' . esc_url( get_permalink( $id ) ) . '" rel="' . esc_url( $type ) . '" class="c-pnNav__link u-flex--aic">' .
			'<span class="c-pnNav__title">' . esc_html( $title ) . '</span>' .
		'</a>';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo apply_filters( 'ark_the__pnlink', $return, $args );
	}
}
