<?php
/**
 * グローバルナビ
 */
$location_name = apply_filters( 'arkhe_gnav_location_name', 'header_menu' );

if ( ! has_nav_menu( $location_name ) ) return;
?>
<nav id="gnav" class="c-gnavWrap">
	<ul class="c-gnav u-flex--aic">
		<?php
			wp_nav_menu( array(
				'walker'          => new \Arkhe_Theme\Walker\Gnav_Menu(),
				'ark_component'   => 'gnav',
				'container'       => '',
				'fallback_cb'     => '',
				'items_wrap'      => '%3$s',
				'theme_location'  => $location_name,
			) );
		?>
	</ul>
</nav>
