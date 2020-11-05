<?php
/**
 * フロントページテンプレート
 */
get_header(); ?>
<main id="main_content" class="<?php Arkhe::main_class(); ?>">
	<div class="<?php Arkhe::main_body_class(); ?>">
		<?php if ( is_home() ) : ?>
			<?php Arkhe::get_part( 'home_content' ); ?>
		<?php else : ?>
			<?php
				while ( have_posts() ) :
					the_post();
					Arkhe::get_part( 'front_content' );
				endwhile;
			?>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
