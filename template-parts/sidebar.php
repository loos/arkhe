<?php
/**
 * 通常のサイドバの中身
 */
if ( is_active_sidebar( 'sidebar-1' ) ) :
	dynamic_sidebar( 'sidebar-1' );
endif;
