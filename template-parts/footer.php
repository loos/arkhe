<?php if ( ! defined( 'ABSPATH' ) ) exit;
	$SETTING = ARKHE_THEME::get_setting();
?>
<footer id="footer" class="l-footer">
	<div class="l-footer__inner">
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
