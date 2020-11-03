<?php
namespace Arkhe_Theme;

/**
 * カスタムメニューの設定
 */
add_action( 'after_setup_theme', '\Arkhe_Theme\register_nav_locations', 9 );
add_filter( 'walker_nav_menu_start_el', '\Arkhe_Theme\hook_walker_nav_menu', 10, 4 );


/**
 * カスタムメニューのロケーション登録
 */
function register_nav_locations() {
	register_nav_menus(
		array(
			'header_menu'  => __( 'Global Navigation', 'arkhe' ),
			'drawer_menu'  => __( 'Inside the drawer menu', 'arkhe' ),
			'footer_menu'  => __( 'Footer', 'arkhe' ),
		)
	);
}


/**
 * リストのHTMLを組み替える
 * 例：「説明」を追加（ナビゲーションの英語テキストに使用）
 */
function hook_walker_nav_menu( $item_output, $item, $depth, $args ) {

	// 特定のメニューに対して処理
	$menu_location = $args->theme_location;

	// サブメニューを持つかどうか
	$has_child = in_array( 'menu-item-has-children', $item->classes, true );

	if ( 'header_menu' === $menu_location || 'drawer_menu' === $menu_location ) {
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
				'<button class="c-submenuToggleBtn u-flex--c" role="button" data-onclick="toggleSubmenu"></button></a>',
				$item_output
			);
		}
	} elseif ( '' === $menu_location ) {
		if ( $has_child ) {
			$item_output = str_replace(
				'</a>',
				'<button class="c-submenuToggleBtn u-flex--c" role="button" data-onclick="toggleSubmenu"></button></a>',
				$item_output
			);
		}
	}

	$item_output = do_shortcode( $item_output );

	return $item_output;
}
