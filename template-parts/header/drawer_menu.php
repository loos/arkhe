<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * ドロワーメニュー
 */
?>
<div id="sp_menu" class="p-spMenu">
	<div class="p-spMenu__inner">
		<div class="p-spMenu__body">
			<div class="p-spMenu__nav">
			<?php
				if ( has_nav_menu( 'nav_sp_menu' ) ) :
				wp_nav_menu(
					array(
						'container'       => false,
						'fallback_cb'     => '',
						'theme_location'  => 'nav_sp_menu',
						'items_wrap'      => '<ul class="c-spnav">%3$s</ul>',
					)
				);
				else :
					wp_nav_menu(
						array(
							'container'       => '',
							'fallback_cb'     => '',
							'theme_location'  => 'header_menu',
							'items_wrap'      => '<ul class="c-spnav">%3$s</ul>',
						)
					);
				endif;
			?>
			</div>
			<?php
			if ( is_active_sidebar( 'drawer_bottom' ) ) :
				echo '<div id="drawer_bottom" class="w-drawerBottom">';
					dynamic_sidebar( 'drawer_bottom' );
				echo '</div>';
			endif;
			?>
		</div>
	</div>
</div>
