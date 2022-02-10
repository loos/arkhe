<?php
namespace Arkhe_Theme\Utility;

trait Image {

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
		$loading = $args['loading'] ?? self::get_lazy_type();
		if ( 'lazy' === $loading || 'eager' === $loading ) {
			$attrs['loading'] = $loading;

		} elseif ( self::is_rest() || self::is_iframe() ) {
			$attrs['loading'] = 'lazy';

		} elseif ( 'lazysizes' === $loading ) {
			$attrs['data-src'] = $attrs['src'];
			$attrs['src']      = $args['placeholder'] ?? self::$placeholder;
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


	/**
	 * <img> にlazyloadを適用
	 */
	public static function set_lazyload( $image, $lazy_type, $placeholder = '' ) {

		if ( self::is_rest() || self::is_iframe() ) $lazy_type = 'lazy';

		if ( 'eager' === $lazy_type || 'lazy' === $lazy_type ) {

			$image = str_replace( ' src=', ' loading="' . $lazy_type . '" src=', $image );

		} elseif ( 'lazysizes' === $lazy_type ) {

			$noscript = '<noscript>' . $image . '</noscript>';

			$placeholder = $placeholder ?: self::$placeholder;
			$image       = str_replace( ' src=', ' src="' . esc_url( $placeholder, array( 'http', 'https', 'data' ) ) . '" data-src=', $image );
			$image       = str_replace( ' srcset=', ' data-srcset=', $image );
			$image       = str_replace( ' class="', ' class="lazyload ', $image );

			$image = preg_replace_callback( '/<img([^>]*)>/', function( $matches ) {
				$props = rtrim( $matches[1], '/' );
				$props = self::set_aspectratio( $props );
				return '<img' . $props . '>';
			}, $image );

			$image .= $noscript;
		}

		return $image;
	}


	/**
	 * width,height から aspectratio を指定
	 */
	public static function set_aspectratio( $props, $src = '' ) {

		// width , height指定を取得
		preg_match( '/\swidth=["\']([0-9]*)["\']/', $props, $width_matches );
		preg_match( '/\sheight=["\']([0-9]*)["\']/', $props, $height_matches );
		$width  = ( $width_matches ) ? $width_matches[1] : '';
		$height = ( $height_matches ) ? $height_matches[1] : '';

		if ( $width && $height ) {
			$props .= ' data-aspectratio="' . $width . '/' . $height . '"';
		}

		return $props;
	}


}
