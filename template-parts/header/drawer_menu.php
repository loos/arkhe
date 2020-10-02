<?php
/**
 * ドロワーメニュー
 */
?>
<div id="drawer_menu" class="p-drawer">
	<div class="p-drawer__inner">
		<div class="p-drawer__body">
			<div class="p-drawer__nav">
			<?php
				if ( has_nav_menu( 'drawer_menu' ) ) :
				wp_nav_menu(
					array(
						'container'       => false,
						'fallback_cb'     => '',
						'theme_location'  => 'drawer_menu',
						'items_wrap'      => '<ul class="c-drawerNav">%3$s</ul>',
					)
				);
				else :
					wp_nav_menu(
						array(
							'container'       => '',
							'fallback_cb'     => '',
							'theme_location'  => 'header_menu',
							'items_wrap'      => '<ul class="c-drawerNav">%3$s</ul>',
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
