<?php
/**
 * 通常のサイドバー
 */
if ( is_active_sidebar( 'sidebar-1' ) ) :
	dynamic_sidebar( 'sidebar-1' );
endif;
