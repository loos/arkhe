<?php
/**
 * メディアページ用テンプレート
 */
get_header(); ?>
<main id="main_content" class="<?php Arkhe::main_class(); ?>">
	<div <?php post_class( Arkhe::main_body_class( false ) ); ?>>
		<?php while ( have_posts() ) : ?>
			<?php
				the_post();
				$post_data = get_post();
				$img_id    = $post_data->ID;
				$img_cap   = $post_data->post_excerpt;
				$img_data  = wp_get_attachment_image_src( $img_id, 'full' );
				$img_src   = ( false !== $img_data ) ? $img_data[0] : '';
			?>
			<?php if ( $img_src ) : ?>
				<h1 class="p-entry__thumb">
					<img src="<?php echo esc_url( $img_src ); ?>" alt="<?php the_title_attribute(); ?>" class="p-entry__thumb__img">
					<figcaption class="p-entry__thumb__figcaption"><?php echo esc_html( $img_cap ); ?></figcaption>
				</h1>
			<?php endif; ?>
			<div class="<?php Arkhe::post_content_class(); ?>">
				<?php the_content(); // 「概要」 ?>
			</div>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>
