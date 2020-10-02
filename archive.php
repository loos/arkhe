<?php
/**
 * アーカイブページ用
 */
get_header(); ?>
	<main id="main_content" class="<?php Arkhe::main_class(); ?>">
		<?php
		if ( is_category() || is_tag() || is_tax() ) :
			Arkhe::get_parts( 'archive/content_term' );
		else :
			Arkhe::get_parts( 'archive/content' );
		endif;
		?>
	</main>
<?php
get_footer();
