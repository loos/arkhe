<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * アーカイブページ用
 */
get_header(); ?>
	<main id="main_content" class="<?php ARKHE_THEME::main_class(); ?>">
		<?php
		if ( is_category() || is_tag() || is_tax() ) :
			ARKHE_THEME::get_parts( 'archive/content_term' );
		else :
			ARKHE_THEME::get_parts( 'archive/content' );
		endif;
		?>
	</main>
<?php
get_footer();
