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

			$return = Arkhe::get_image( $logo_id, array(
				'class'    => 'c-headLogo__img',
				'sizes'    => $logo_sizes,
				'alt'      => get_option( 'blogname' ),
				'loading'  => 'eager',
				'decoding' => 'async',
			) );

		} else {
			// ヘッダーオーバーレイ有効時

			$ovrly_logo_id = Arkhe::get_setting( 'head_logo_overlay' ) ?: $logo_id;

			$ovrly_logo = Arkhe::get_image( $ovrly_logo_id, array(
				'class'    => 'c-headLogo__img -top',
				'sizes'    => $logo_sizes,
				'alt'      => get_option( 'blogname' ),
				'loading'  => 'eager',
				'decoding' => 'async',
			) );

			$common_logo = Arkhe::get_image( $logo_id, array(
				'class'    => 'c-headLogo__img -common',
				'sizes'    => $logo_sizes,
				'alt'      => get_option( 'blogname' ),
				'loading'  => 'lazy',
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
		echo apply_filters( 'ark_the__tagline', $return );
	}
}


/**
 * アイキャッチ画像を取得
 */
if ( ! function_exists( 'ark_the__thumbnail' ) ) {
	function ark_the__thumbnail( $args ) {
		$the_id    = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
		$class     = isset( $args['class'] ) ? $args['class'] : '';
		$size      = isset( $args['size'] ) ? $args['size'] : 'full';
		$sizes     = isset( $args['sizes'] ) ? $args['sizes'] : false;
		$srcset    = isset( $args['srcset'] ) ? $args['srcset'] : false;
		$lazy_type = isset( $args['lazy_type'] ) ? $args['lazy_type'] : Arkhe::get_lazy_type();
		$decoding  = isset( $args['decoding'] ) ? $args['decoding'] : false;
		// $echo      = isset( $args['echo'] ) ? $args['echo'] : false;
		// $use_noimg = $args['use_noimg'] ?? true;

		$thumb_id = 0;
		$thumb    = '';

		if ( has_post_thumbnail( $the_id ) ) {

			$thumb_id = get_post_thumbnail_id( $the_id );

		} elseif ( ARKHE_NOIMG_ID ) {

			$thumb_id = ARKHE_NOIMG_ID;

		}

		if ( $thumb_id ) {
			$thumb = Arkhe::get_image( $thumb_id, array(
				'class'    => $class,
				'size'     => $size,
				'srcset'   => $srcset,
				'sizes'    => $sizes,
				'decoding' => $decoding,
				'loading'  => $lazy_type,
			));
		} else {
			// デフォルトNOIMG
			$thumb = '<img src="' . esc_url( ARKHE_NOIMG_URL ) . '" alt="" class="' . esc_attr( $class ) . '">';
			$thumb = Arkhe::set_lazyload( $thumb, $lazy_type );
		}

		// phpcs:ignore WordPress.Security.EscapeOutput
		echo apply_filters( 'ark_the__thumbnail', $thumb, $args );
	}
}


/**
 * 投稿の日付データを出力 (アーカイブと投稿ページで使用)
 */
if ( ! function_exists( 'ark_the__postdate' ) ) {
	function ark_the__postdate( $timestamp = null, $type = 'posted' ) {

		if ( ! is_numeric( $timestamp ) ) return;
		if ( null === $timestamp ) return;

		$date_format = get_option( 'date_format' );
		$type_class  = "-{$type}";

		$return = '<time class="c-postTimes__item u-flex--aic ' . esc_attr( $type_class ) . '" datetime="' . esc_attr( wp_date( 'Y-m-d', $timestamp ) ) . '">' .
			Arkhe::get_svg( $type, array( 'class' => 'c-postMetas__icon' ) ) .
			esc_html( wp_date( $date_format, $timestamp ) ) .
		'</time>';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo apply_filters( 'ark_the__postdate', $return, $timestamp, $type );
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
		$svg   = 'prev' === $type ? 'chevron-left' : 'chevron-right';

		$return = '<a href="' . esc_url( get_permalink( $id ) ) . '" rel="' . esc_url( $type ) . '" class="c-pnNav__link u-flex--aic">' .
			Arkhe::get_svg( $svg, array( 'class' => 'c-pnNav__svg' ) ) .
			'<span class="c-pnNav__title">' . esc_html( $title ) . '</span>' .
		'</a>';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo apply_filters( 'ark_the__pnlink', $return, $args );
	}
}


/**
 * サブメニュー展開用ボタン
 */
if ( ! function_exists( 'ark_get__submenu_toggle_btn' ) ) {
	function ark_get__submenu_toggle_btn() {
		return '<button class="c-submenuToggleBtn u-flex--c" data-onclick="toggleSubmenu">' .
			Arkhe::get_svg( 'chevron-down', array( 'class' => 'c-submenuToggleBtn__svg' ) ) .
		'</button>';
	}
}
