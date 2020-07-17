<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿ページテンプレート
 */
get_header();
while ( have_posts() ) :
the_post(); ?>
	<main id="main_content" class="<?php ARKHE_THEME::main_class(); ?>">
		<article <?php post_class( ARKHE_THEME::main_body_class( false ) ); ?> data-postid="<?php the_ID(); ?>">
			<?php ARKHE_THEME::get_parts( 'single/content' ); ?>
		</article>
	</main>
<?php
endwhile;
get_footer();
