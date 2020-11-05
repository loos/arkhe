<?php
/**
 * グローバルナビ
 */
$gnav = wp_nav_menu(
	array(
		'container'       => '',
		'fallback_cb'     => '',
		'theme_location'  => apply_filters( 'arkhe_gnav_location_name', 'header_menu' ),
		'items_wrap'      => '%3$s',
		'echo'            => false,
	)
);

if ( ! $gnav ) return; ?>
<nav id="gnav" class="c-gnavWrap">
	<ul class="c-gnav u-flex--aic">
		<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $gnav;
		?>
	</ul>
</nav>
