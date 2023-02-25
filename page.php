<?php
/**
 * 固定ページテンプレート
 */
get_header();
while ( have_posts() ) :
	the_post();
	$the_id = get_the_ID();
?>
	<main <?php Arkhe::main_attrs(); ?>>
		<article <?php Arkhe::main_body_attrs(); ?>>
			<?php
				do_action( 'arkhe_start_page_main', $the_id );
				Arkhe::get_part( 'page' );
				do_action( 'arkhe_end_page_main', $the_id );
			?>
		</article>
	</main>
<?php
endwhile;
get_footer();
