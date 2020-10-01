<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * フロントページテンプレート
 */
get_header(); ?>
<main id="main_content" class="<?php Arkhe_Theme::main_class(); ?>">
	<div class="<?php Arkhe_Theme::main_body_class(); ?>">
		<?php if ( is_home() ) : ?>
			<?php Arkhe_Theme::get_parts( 'home_content' ); ?>
		<?php else : ?>
			<?php
				while ( have_posts() ) :
					the_post();
					Arkhe_Theme::get_parts( 'front_content' );
				endwhile;
			?>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
