<?php
/**
 * アーカイブページ用テンプレート
 */
get_header(); ?>
	<main id="main_content" class="<?php Arkhe::main_class(); ?>">
		<div <?php post_class( Arkhe::main_body_class( false ) ); ?>>
			<?php
				do_action( 'arkhe_start_archive_main_content' );
				if ( is_category() || is_tag() || is_tax() ) :
					Arkhe::get_part( 'archive/content_term' );
				else :
					Arkhe::get_part( 'archive/content' );
				endif;
				do_action( 'arkhe_end_archive_main_content' );
			?>
		<div>
	</main>
<?php
get_footer();
