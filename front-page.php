<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * フロントページテンプレート
 */
get_header(); ?>
<main id="main_content" class="<?php ARKHE_THEME::main_class(); ?>">
	<div class="<?php ARKHE_THEME::main_body_class(); ?>">
		<?php if ( is_home() ) : ?>
			<?php ARKHE_THEME::get_parts( 'home_content' ); ?>
		<?php else : ?>
			<?php
				while ( have_posts() ) :
					the_post();
					ARKHE_THEME::get_parts( 'front_content' );
				endwhile;
			?>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
