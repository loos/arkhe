<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ウィジェット登録
 */
add_action( 'after_setup_theme', 'arkhe_hook__update_check' );

function arkhe_hook__update_check() {
	\ARKHE_THEME\Update::version_check();
}
