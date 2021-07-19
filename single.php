<?php
/**
 * 投稿ページテンプレート
 */
get_header();
while ( have_posts() ) :
	the_post();
	$the_id = get_the_ID();
?>
	<main id="main_content" class="<?php Arkhe::main_class(); ?>">
		<article <?php post_class( Arkhe::get_main_body_class() ); ?> data-postid="<?php echo esc_attr( $the_id ); ?>">
			<?php
				do_action( 'arkhe_start_entry_main', $the_id );
				Arkhe::get_part( 'single' );
				do_action( 'arkhe_end_entry_main', $the_id );
			?>
		</article>
	</main>
<?php
endwhile;
get_footer();
