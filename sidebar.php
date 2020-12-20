<?php
/**
 * サイドバーテンプレート
 */
?>
<aside id="sidebar" class="l-sidebar">
	<?php
		do_action( 'arkhe_start_sidebar' );
		Arkhe::get_part( 'sidebar' );
		do_action( 'arkhe_end_sidebar' );
	?>
</aside>
