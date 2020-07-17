<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * インライン出力などをする
 */
add_action( 'wp_head', 'arkhe_hook__output_front_style', 9 );
add_action( 'admin_head', 'arkhe_hook__output_admin_style', 20 );

/**
 * wp_headで出力するコード 優先度：9
 */
if ( ! function_exists( 'arkhe_hook__output_front_style' ) ) :
function arkhe_hook__output_front_style() {

}
endif;


/**
 * admin_headで出力するコード
 * スタイル用
 */
if ( ! function_exists( 'arkhe_hook__output_admin_style' ) ) :
function arkhe_hook__output_admin_style() {

}
endif;
