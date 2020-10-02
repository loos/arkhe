<?php get_header(); ?>
<main id="main_content" class="<?php Arkhe::main_class(); ?>">
	<div class="<?php Arkhe::main_body_class(); ?>">
		<h1 class="p-404__title">
			<?php esc_html_e( 'The page was not found.', 'arkhe' ); ?>
		</h1>
		<div class="<?php Arkhe::post_content_class(); ?>">
			<p class="u-ta-c">
				<?php esc_html_e( 'The page you are looking for may have been moved or deleted.', 'arkhe' ); ?>
			</p>
			<p class="u-ta-c">
				<?php esc_html_e( 'Please enter a keyword below to search.', 'arkhe' ); ?>
			</p>
			<?php echo get_search_form(); ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>
