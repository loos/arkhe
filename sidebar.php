<?php
/**
 * サイドバーテンプレート
 */
?>
<aside id="sidebar" class="l-content__sidebar">
	<?php
		do_action( 'arkhe_before_sidebar_content' );
		Arkhe::get_part( 'sidebar_content' );
		do_action( 'arkhe_after_sidebar_content' );
	?>
</aside>
