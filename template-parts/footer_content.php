<?php
$setting = Arkhe::get_setting();

// ウィジェットの使用状況
$is_active_footer1 = is_active_sidebar( 'footer-1' );
$is_active_footer2 = is_active_sidebar( 'footer-2' );

?>
<footer id="footer" class="l-footer">
	<div class="l-footer__inner">
		<?php do_action( 'arkhe_start_footer_inner' ); ?>
		<?php if ( $is_active_footer1 || $is_active_footer2 ) : ?>
			<div class="l-footer__widgets<?php if ( $is_active_footer1 && $is_active_footer2 ) echo ' has-columns'; ?>">
				<div class="l-container">
					<?php if ( $is_active_footer1 ) : ?>
						<div class="w-footer -widget1">
							<?php dynamic_sidebar( 'footer-1' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( $is_active_footer2 ) : ?>
						<div class="w-footer -widget2">
							<?php dynamic_sidebar( 'footer-2' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="l-footer__foot">
			<div class="l-container">
				<?php
				do_action( 'arkhe_start_footer_foot_content' );
					wp_nav_menu(
						array(
							'container'       => false,
							'fallback_cb'     => '',
							'theme_location'  => 'footer_menu',
							'items_wrap'      => '<ul class="l-footer__nav u-flex--c">%3$s</ul>',
							'link_before'     => '',
							'link_after'      => '',
						)
					);
				?>
				<?php do_action( 'arkhe_before_copyright' ); ?>
				<p class="c-copyright"><?php echo esc_html( $setting['copyright'] ); ?></p>
				<?php do_action( 'arkhe_after_copyright' ); ?>
			</div>
		</div>
		<?php do_action( 'arkhe_end_footer_inner' ); ?>
	</div>
</footer>
