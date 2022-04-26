<?php
namespace Arkhe_Theme\Utility;

defined( 'ABSPATH' ) || exit;

trait SVG {

	/**
	 * svgアイコン 出力
	 */
	public static function the_svg( $icon_name, $attrs = array() ) {
		echo self::get_svg( $icon_name, $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput
	}

	/**
	 * svgアイコン 取得
	 */
	public static function get_svg( $icon_name, $attrs = array() ) {
		if ( ! $icon_name ) return '';

		$path     = '';
		$size     = $attrs['size'] ?? '16';
		$class    = $attrs['class'] ?? '';
		$view_box = '0 0 40 40';

		switch ( $icon_name ) {
			case 'arkhe-logo':
				$path = '<polygon points="34.96,1.89 14.29,22.56 14.29,20.34 14.33,20.29 21.09,13.53 19.31,13.53 30.73,2.11 30.95,1.89 "/><polygon points="26.58,13.32 26.58,15.1 16.12,25.55 15.85,25.82 18.08,25.82 38,5.9 38,1.89 "/><polygon points="38,12.95 25.44,25.51 26.89,25.51 26.89,38.11 2,38.11 2,13.22 14.29,13.22 14.29,11.5 23.9,1.89  27.9,1.89 27.69,2.11 27.69,2.11 14.29,15.51 14.29,14.71 3.49,14.71 3.49,36.61 25.4,36.61 25.4,25.55 25.13,25.82 22.9,25.82 23.17,25.55 26.57,22.14 26.57,20.36 38,8.94"/><polygon points="27.69,2.11 14.29,15.51 27.69,2.11"/><polygon points="32.18,25.82 38,20 38,15.99 28.17,25.82"/><polygon points="38,25.82 38,23.04 35.22,25.82"/><polygon points="20.86,1.89 20.64,2.11 14.29,8.46 14.29,4.46 16.85,1.89"/>';
				break;
			case 'home':
				$path = '<path d="M16.2,36.3v-7.8h7.8v7.8h9.8V20.7H37c0.9,0,1.3-1.1,0.5-1.7L21.3,4.2c-0.7-0.7-1.9-0.7-2.6,0L2.3,18.9 c-0.7,0.5-0.3,1.7,0.5,1.7h3.3v15.7C6.2,36.3,16.2,36.3,16.2,36.3z" />';
				break;
			case 'folder':
				$path = '<path d="M15.2,8l3.6,3.6H35V32H5V8H15.2 M16.4,5H2v30h36V8.6H20L16.4,5L16.4,5z"/>';
				break;
			case 'tag':
				$path = '<path d="M9.3,8.3c-1.2,1.2-1.2,3.3,0,4.5c1.3,1.3,3.3,1.3,4.5,0s1.3-3.3,0-4.5C12.6,7.1,10.5,7.1,9.3,8.3z"/>
				<path d="M20.9,2l-0.3-0.3l-17.9,0l0,17.9l18.6,18.6l18-18L20.9,2z M5.4,4.5l14.1,0l15.9,15.9L21.3,34.4L5.5,18.5L5.4,4.5z"/>';
				break;
			case 'menu':
				$path = '<path d="M37.8 21.4h-35.6c-0.1 0-0.2-0.1-0.2-0.2v-2.4c0-0.1 0.1-0.2 0.2-0.2h35.6c0.1 0 0.2 0.1 0.2 0.2v2.4c0 0.1-0.1 0.2-0.2 0.2z"></path><path d="M37.8 11.7h-35.6c-0.1 0-0.2-0.1-0.2-0.2v-2.4c0-0.1 0.1-0.2 0.2-0.2h35.6c0.1 0 0.2 0.1 0.2 0.2v2.4c0 0.2-0.1 0.2-0.2 0.2z"></path><path d="M37.8 31.1h-35.6c-0.1 0-0.2-0.1-0.2-0.2v-2.4c0-0.1 0.1-0.2 0.2-0.2h35.6c0.1 0 0.2 0.1 0.2 0.2v2.4c0 0.1-0.1 0.2-0.2 0.2z"></path>';
				break;
			case 'close':
				$path = '<path d="M33 35l-28-28c-0.1-0.1-0.1-0.2 0-0.3l1.7-1.7c0.1-0.1 0.2-0.1 0.3 0l28 28c0.1 0.1 0.1 0.2 0 0.3l-1.7 1.7c-0.1 0.1-0.2 0.1-0.3 0z"></path><path d="M35 7l-28 28c-0.1 0.1-0.2 0.1-0.3 0l-1.7-1.7c-0.1-0.1-0.1-0.2 0-0.3l28-28c0.1-0.1 0.2-0.1 0.3 0l1.7 1.7c0.1 0.1 0.1 0.2 0 0.3z"></path>';
				break;
			case 'posted':
				$path = '<path d="M21,18.5v-9C21,9.2,20.8,9,20.5,9h-2C18.2,9,18,9.2,18,9.5v12c0,0.3,0.2,0.5,0.5,0.5h10c0.3,0,0.5-0.2,0.5-0.5v-2 c0-0.3-0.2-0.5-0.5-0.5h-7C21.2,19,21,18.8,21,18.5z"/><path d="M20,39C9.5,39,1,30.5,1,20S9.5,1,20,1s19,8.5,19,19S30.5,39,20,39z M20,3.8C11.1,3.8,3.8,11.1,3.8,20S11.1,36.2,20,36.2 S36.2,28.9,36.2,20S28.9,3.8,20,3.8z"/>';
				break;
			case 'modified':
				$path = '<path d="M36.3,14C33.1,5,22.9,0.3,13.9,3.6c-4.1,1.5-7.3,4.3-9.3,7.8l2.7,1.3c1.6-2.8,4.2-5.1,7.6-6.4c7.5-2.7,15.8,1.1,18.6,8.7 L30.6,16l6.5,4.3l2.2-7.5L36.3,14L36.3,14z"/><path d="M31.7,28.5c-1.6,2.3-3.9,4.1-6.9,5.2C17.3,36.4,9,32.5,6.3,25l2.8-1l-6.3-4.2L0.6,27l2.8-1c3.3,9,13.4,13.7,22.4,10.5 c3.7-1.3,6.5-3.8,8.5-6.7L31.7,28.5z"/>';
				break;
			case 'chevron-up':
				$path = '<path d="M8,27l-2.1-2.1l13.8-13.8c0.2-0.2,0.5-0.2,0.7,0l13.8,13.8L32,27L20,16L8,27z"/>';
				break;
			case 'chevron-down':
				$path = '<path d="M32,13l2.1,2.1L20.3,28.9c-0.2,0.2-0.5,0.2-0.7,0L5.9,15.1L8,13l12,11L32,13z"/>';
				break;
			case 'chevron-left':
				$path = '<path d="M27,32l-2.1,2.1L11.1,20.3c-0.2-0.2-0.2-0.5,0-0.7L24.9,5.9L27,8L16,20L27,32z"/>';
				break;
			case 'chevron-right':
				$path = '<path d="M13,8l2.1-2.1l13.8,13.8c0.2,0.2,0.2,0.5,0,0.7L15.1,34.1L13,32l11-12L13,8z"/>';
				break;
			case 'search':
				$path = '<path d="M37.8 34.8l-11.9-11.2c1.8-2.3 2.9-5.1 2.9-8.2 0-7.4-6-13.4-13.4-13.4s-13.4 6-13.4 13.4 6 13.4 13.4 13.4c3.1 0 5.9-1.1 8.2-2.8l11.2 11.9c0.2 0.2 1.3 0.2 1.5 0l1.5-1.5c0.3-0.3 0.3-1.4 0-1.6zM15.4 25.5c-5.6 0-10.2-4.5-10.2-10.1s4.6-10.2 10.2-10.2 10.2 4.6 10.2 10.2-4.6 10.1-10.2 10.1z"></path>';
				break;
			case 'link':
				$path = '<path d="M31.6 20.6l3.9-3.9c1.6-1.6 2.5-3.8 2.5-6.1s-0.9-4.5-2.5-6.1c-1.6-1.6-3.8-2.5-6.1-2.5s-4.4 0.9-6.1 2.5l-7.1 7.1c-3.3 3.3-3.3 8.8 0 12.1 0.6 0.6 1.6 0.6 2.2 0s0.6-1.6 0-2.2c-2.2-2.2-2.2-5.7 0-7.8l7.1-7.1c1-1 2.4-1.6 3.9-1.6s2.9 0.6 3.9 1.6c2.2 2.2 2.2 5.7 0 7.8l-3.9 3.9c-0.3 0.3-0.4 0.7-0.4 1.1s0.2 0.8 0.4 1.1c0.6 0.7 1.6 0.7 2.2 0.1z"></path>
				<path d="M4.5 23.3c-3.3 3.3-3.3 8.8 0 12.1 1.6 1.6 3.8 2.5 6.1 2.5s4.5-0.9 6.1-2.5l7.1-7.1c3.4-3.3 3.4-8.8 0-12.1-0.6-0.6-1.6-0.6-2.2 0-0.3 0.3-0.4 0.7-0.4 1.1s0.2 0.8 0.4 1.1c2.2 2.2 2.2 5.7 0 7.8l-7.1 7.1c-1 1-2.4 1.6-3.9 1.6s-2.9-0.6-3.9-1.6c-2.2-2.2-2.2-5.7 0-7.8l3.9-3.9c0.6-0.6 0.6-1.6 0-2.2-0.3-0.3-0.7-0.4-1.1-0.4s-0.8 0.1-1.1 0.4l-3.9 3.9z"></path>';
				break;
			default:
				break;
		}

		$svg = '';
		if ( $path ) {
			$svg_class = 'arkhe-svg-' . $icon_name;
			if ( $class ) {
				$svg_class .= ' ' . $class;
			}

			$svg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="' . esc_attr( $svg_class ) . '" width="' . esc_attr( $size ?: '16' ) . '" height="' . esc_attr( $size ?: '16' ) . '" viewBox="' . $view_box . '" role="img" aria-hidden="true" focusable="false">' . $path . '</svg>';
		}

		return apply_filters( 'arkhe_get_svg', $svg, $icon_name, $attrs );
	}
}