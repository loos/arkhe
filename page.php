<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 固定ページテンプレート
 */
get_header();
while ( have_posts() ) :
	the_post(); ?>
	<main id="main_content" class="<?php ARKHE_THEME::main_class(); ?>">
		<article <?php post_class( ARKHE_THEME::main_body_class( false ) ); ?> data-postid="<?php the_ID(); ?>">
			<?php ARKHE_THEME::get_parts( 'page/content' ); ?>
		</article>
	</main>
<?php
endwhile;
get_footer();
