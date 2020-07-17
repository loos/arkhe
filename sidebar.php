<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<aside id="sidebar" class="l-content__sidebar">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) :
		dynamic_sidebar( 'sidebar-1' );
	endif; ?>
</aside>
