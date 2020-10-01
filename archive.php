<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * アーカイブページ用
 */
get_header(); ?>
	<main id="main_content" class="<?php Arkhe_Theme::main_class(); ?>">
		<?php
		if ( is_category() || is_tag() || is_tax() ) :
			Arkhe_Theme::get_parts( 'archive/content_term' );
		else :
			Arkhe_Theme::get_parts( 'archive/content' );
		endif;
		?>
	</main>
<?php
get_footer();
