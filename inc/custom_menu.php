<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * カスタムメニューの設定
 */
add_action( 'after_setup_theme', 'arkhe_hook__register_nav_menus', 9 );
add_filter( 'walker_nav_menu_start_el', 'arkhe_hook__walker_nav_menu_start_el', 10, 4 );


/**
 * カスタムメニューのロケーション登録
 */

if ( ! function_exists( 'arkhe_hook__register_nav_menus' ) ) :
function arkhe_hook__register_nav_menus() {
	register_nav_menus(
		array(
			'header_menu'  => 'グローバルナビ',
			'nav_sp_menu'  => 'スマホ開閉メニュー内',
			'footer_menu'  => 'フッター',
		)
	);
}
endif;

/**
 * リストのHTMLを組み替える
 * 例：「説明」を追加（ナビゲーションの英語テキストに使用）
 */
if ( ! function_exists( 'arkhe_hook__walker_nav_menu_start_el' ) ) :
function arkhe_hook__walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {

	// 特定のメニューに対して処理
	$menu_location = $args->theme_location;

	// サブメニューを持つかどうか
	$has_child = in_array( 'menu-item-has-children', $item->classes, true );

	if ( 'header_menu' === $menu_location || 'nav_sp_menu' === $menu_location ) {
		if ( 0 === $depth ) {
			$item_output = preg_replace(
				'/<a([^>]*)>([^<]*)<\/a>/',
				'<a$1><span class="__mainText">$2</span></a>',
				$item_output
			);

			if ( ! empty( $item->description ) ) {
				$item_output = str_replace(
					'</a>',
					'</span><small class="__subText">' . esc_html( $item->description ) . '</small></a>',
					$item_output
				);
			}
		}

		if ( $has_child ) {
			$item_output = str_replace(
				'</a>',
				'<button class="c-submenuToggleBtn" role="button" data-onclick="toggleSubmenu"></button></a>',
				$item_output
			);
		}
	} elseif ( '' === $menu_location ) {
		if ( $has_child ) {
			$item_output = str_replace(
				'</a>',
				'<button class="c-submenuToggleBtn" role="button" data-onclick="toggleSubmenu"></button></a>',
				$item_output
			);
		}
	}

	$item_output = do_shortcode( $item_output );

	return $item_output;
}
endif;
