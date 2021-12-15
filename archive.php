<?php
/**
 * アーカイブページ用テンプレート
 */
get_header(); ?>
	<main id="main_content" class="<?php Arkhe::main_class(); ?>">
		<div <?php post_class( Arkhe::get_main_body_class() ); ?>>
			<?php
				do_action( 'arkhe_start_archive_main' );
				if ( is_category() || is_tag() || is_tax() ) :
					Arkhe::get_part( 'archive_term' );
				else :
					Arkhe::get_part( 'archive' );
				endif;
				do_action( 'arkhe_end_archive_main' );
			?>
		</div>
	</main>
<?php
get_footer();
