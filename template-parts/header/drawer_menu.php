<?php
/**
 * ドロワーメニュー
 */
?>
<div id="drawer_menu" class="p-drawer">
	<div class="p-drawer__inner">
		<div class="p-drawer__body">
			<?php do_action( 'arkhe_start_drawer_body' ); ?>
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
				do_action( 'arkhe_after_drawer_nav' );

				if ( is_active_sidebar( 'drawer-bottom' ) ) :
					echo '<div id="drawer_bottom" class="w-drawerBottom">';
						dynamic_sidebar( 'drawer-bottom' );
					echo '</div>';
				endif;

				do_action( 'arkhe_end_drawer_body' );
			?>
			<button type="button" class="p-drawer__close u-flex--aic" data-onclick="toggleMenu">
				<i class="arkhe-icon-close" role="img" aria-hidden="true"></i><?php esc_html_e( 'CLOSE', 'arkhe' ); ?>
			</button>
		</div>
	</div>
</div>
