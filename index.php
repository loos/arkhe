<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * index.php
 */
get_header();
?>
<main id="main_content" class="<?php ARKHE_THEME::main_class(); ?>">
	<div <?php post_class( ARKHE_THEME::main_body_class( false ) ); ?>>
	<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
			?>
				<div class="<?php ARKHE_THEME::post_content_class(); ?>">
					<?php the_content(); ?>
				<div>
			<?php
			endwhile;
		endif;
	?>
	</div>
</main>
<?php
get_footer();
