<?php
/**
 * アーカイブページ用テンプレート
 */
get_header(); ?>
	<main <?php Arkhe::main_attrs(); ?>>
		<div <?php Arkhe::main_body_attrs(); ?>>
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
