<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

while ( have_posts() ) :
	the_post();
	$post_data = get_post();
	$img_id    = $post_data->ID;
	$img_cap   = $post_data->post_excerpt;
	$img_data  = wp_get_attachment_image_src( $img_id, 'full' );
	$img_src   = ( false !== $img_data ) ? $img_data[0] : '';
?>
	<main id="main_content" class="<?php ARKHE_THEME::main_class(); ?>">
		<div <?php post_class( ARKHE_THEME::main_body_class( false ) ); ?>>
			<?php if ( $img_src ) : ?>
				<h1 class="p-entry__thumb">
					<img src="<?php echo esc_url( $img_src ); ?>" alt="<?php the_title_attribute(); ?>" class="p-entry__thumb__img">
					<figcaption class="p-entry__thumb__figcaption"><?php echo esc_html( $img_cap ); ?></figcaption>
				</h1>
			<?php endif; ?>
			<div class="<?php ARKHE_THEME::post_content_class(); ?>">
				<?php the_content(); // 「概要」 ?>
			</div>
		</div>
	</main>
<?php
endwhile;
get_footer();
