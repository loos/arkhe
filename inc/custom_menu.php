<?php
namespace Arkhe_Theme;

/**
 * カスタムメニューのロケーション登録
 */
add_action( 'after_setup_theme', __NAMESPACE__ . '\register_nav_locations', 9 );
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
 * 従来ウィジェットで呼び出されるナビゲーションに開閉サブメニュー用のクラスを付与
 */
add_filter( 'wp_nav_menu_items', __NAMESPACE__ . '\hook_wp_nav_menu_items', 10, 2 );
function hook_wp_nav_menu_items( $items, $args ) {

	$location = isset( $args->theme_location ) ? $args->theme_location : '';

	if ( '' === $location ) {
		$regex = '/<li ([^>]*)>\s*(<a(?:(?!<\/a>).)*)<\/a>\s*<ul/s';
		$items = preg_replace_callback( $regex, function( $matches ) {
			$li_props = $matches[1];
			$a_tag    = $matches[2] . ark_get__submenu_toggle_btn() . '</a>';
			$li_props = str_replace( 'menu-item-has-children', 'menu-item-has-children has-child--acc', $li_props );
			return '<li ' . $li_props . '>' . $a_tag . '<ul';
		}, $items );
	}

	return $items;
}
