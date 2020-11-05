<?php
/**
 * index.php
 */
get_header(); ?>
<main id="main_content" class="<?php Arkhe::main_class(); ?>">
	<div <?php post_class( Arkhe::main_body_class( false ) ); ?>>
	<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
			?>
				<div class="<?php Arkhe::post_content_class(); ?>">
					<?php the_content(); ?>
				<div>
			<?php
			endwhile;
		endif;
	?>
	</div>
</main>
<?php get_footer(); ?>
