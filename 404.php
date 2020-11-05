<?php
/**
 * 404ページ用テンプレート
 */
get_header(); ?>
<main id="main_content" class="<?php Arkhe::main_class(); ?>">
	<div class="<?php Arkhe::main_body_class(); ?>">
		<?php do_action( 'arkhe_start_404_main_content' ); ?>
		<h1 class="p-404__title">
			<?php
				echo wp_kses(
					apply_filters( 'arkhe_404_title', __( 'The page was not found.', 'arkhe' ) ),
					\Arkhe::$allowed_text_html
				);
			?>
		</h1>
		<?php do_action( 'arkhe_before_404_content' ); ?>
		<div class="<?php Arkhe::post_content_class(); ?>">
			<?php
				$content_404 = '<p class="u-ta-c">' .
					__( 'The page you are looking for may have been moved or deleted.', 'arkhe' ) .
					'<br>' .
					__( 'Please enter a keyword below to search.', 'arkhe' ) .
				'</p>';
				echo wp_kses_post( apply_filters( 'arkhe_404_content', $content_404 ) );
			?>
			<?php echo get_search_form(); ?>
		</div>
		<?php do_action( 'arkhe_after_404_content' ); ?>
	</div>
	<?php do_action( 'arkhe_end_404_main_content' ); ?>
</main>
<?php get_footer(); ?>
