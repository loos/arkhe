<?php
/**
 * 投稿ページテンプレート
 */
get_header();
while ( have_posts() ) :
the_post(); ?>
	<main id="main_content" class="<?php Arkhe_Theme::main_class(); ?>">
		<article <?php post_class( Arkhe_Theme::main_body_class( false ) ); ?> data-postid="<?php the_ID(); ?>">
			<?php Arkhe_Theme::get_parts( 'single/content' ); ?>
		</article>
	</main>
<?php
endwhile;
get_footer();
