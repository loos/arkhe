<?php
namespace Arkhe_Theme\Output;

/**
 * Arkheを使用しているかどうかをJS側で判別するためのグローバル変数を出力
 */
add_action( 'admin_head', function() {
	echo '<script>window.arkheTheme = 1;</script>' . PHP_EOL;
} );


/**
 * Add skip link
 */
add_action( 'wp_body_open', __NAMESPACE__ . '\hook_wp_body_open', 5 );
function hook_wp_body_open() {
	echo '<a class="skip-link screen-reader-text" href="#main_content">' . esc_html__( 'Skip to the content', 'arkhe' ) . '</a>';
}


/**
 * wp_head() での出力
 */
// add_action( 'wp_head', __NAMESPACE__ . '\hook_wp_head', 5 );
// function hook_wp_head() {}


/**
 * wp_footer() での出力
 */
add_action( 'wp_footer', __NAMESPACE__ . '\hook_wp_footer', 5 );
function hook_wp_footer() {
	// スクロール監視用
	echo '<div class="l-scrollObserver" aria-hidden="true"></div>';
}
