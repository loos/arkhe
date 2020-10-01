<?php get_header(); ?>
<main id="main_content" class="<?php Arkhe_Theme::main_class(); ?>">
	<div <?php post_class( Arkhe_Theme::main_body_class( false ) ); ?>>
	<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
			?>
				<div class="<?php Arkhe_Theme::post_content_class(); ?>">
					<?php the_content(); ?>
				<div>
			<?php
			endwhile;
		endif;
	?>
	</div>
</main>
<?php get_footer(); ?>
