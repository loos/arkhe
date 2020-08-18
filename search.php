<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 検索結果画面
 */
get_header();

// リストタイプ
$list_type = apply_filters( 'arkhe_list_type_on_search', ARKHE_LIST_TYPE );
?>
<main id="main_content" class="<?php ARKHE_THEME::main_class(); ?>">
	<div class="<?php ARKHE_THEME::main_body_class(); ?>">
		<h1 class="p-archive__title c-pageTitle">
			<?php
				// translators: %s is the value of get_search_query().
				echo esc_html( sprintf( __( 'Search results for "%s"', 'arkhe' ), get_search_query() ) );
			?>
		</h1>
		<?php
			// 投稿一覧
			ARKHE_THEME::get_parts( 'post_list/main_query', array( 'list_type' => $list_type ) );

			// ページャー
			the_posts_pagination(
				array(
					'mid_size'           => 2,
					'screen_reader_text' => null,
				)
			);
		?>
	</div>
</main>
<?php get_footer(); ?>
