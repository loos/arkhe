<?php if ( ! defined( 'ABSPATH' ) ) exit;
	$SETTING = ARKHE_THEME::get_setting();
?>
<footer id="footer" class="l-footer">
	<div class="l-footer__inner">
		<?php if ( is_active_sidebar( 'footer' ) ) : ?>
			<div class="l-footer__content">
				<div class="l-container">
					<?php dynamic_sidebar( 'footer' ); ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="l-footer__foot">
			<div class="l-container">
				<?php
					wp_nav_menu(
						array(
							'container'       => false,
							'fallback_cb'     => '',
							'theme_location'  => 'footer_menu',
							'items_wrap'      => '<ul class="l-footer__nav">%3$s</ul>',
							'link_before'     => '',
							'link_after'      => '',
						)
					);
				?>
				<p class="copyright"><?php echo esc_html( $SETTING['copyright'] ); ?></p>
				<?php do_action( 'arkhe_after_copyright' ); ?>
			</div>
		</div>
	</div>
</footer>
