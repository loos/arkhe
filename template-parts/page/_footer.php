<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 固定ページ下部
 */
$the_id = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();

// ページ下部ウィジェット
// if ( is_active_sidebar( 'page_bottom' ) ) :
// 	echo '<div class="w-pageBottom">';
// 		dynamic_sidebar( 'page_bottom' );
// 	echo '</div>';
// endif;
