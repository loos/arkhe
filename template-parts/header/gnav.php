<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * グローバルナビ
 */
$gnav = wp_nav_menu(
	array(
		'container'       => '',
		'fallback_cb'     => '',
		'theme_location'  => 'header_menu',
		'items_wrap'      => '%3$s',
		'echo'            => false,
	)
);
if ( ! $gnav ) return; ?>
<nav id="gnav" class="c-gnavWrap l-container">
	<ul class="c-gnav">
		<?php // @codingStandardsIgnoreStart
			echo $gnav;
		// @codingStandardsIgnoreEnd ?>
	</ul>
</nav>
