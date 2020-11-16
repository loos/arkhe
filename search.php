<?php
/**
 * 検索結果ページ用テンプレート
 * phpcs:disable WordPress.Security
 */
get_header();

// 検索されたテキスト
$search_query  = get_search_query();
$searched_text = $search_query ? '"' . $search_query . '"' : '';

$searched_term = '';
$cat_name      = '';
$tag_name      = '';

// カテゴリーの指定があれば
if ( isset( $_GET['cat'] ) ) {
	$catid    = $_GET['cat'];
	$cat_data = get_term_by( 'id', $catid, 'category' );
	$cat_name = ( $cat_data ) ? $cat_data->name : $catid;

	$searched_term .= $cat_name;
}

// タグの指定があれば
if ( isset( $_GET['tag'] ) ) {
	$tag_slug = $_GET['tag'];
	$tag_data = get_term_by( 'slug', $tag_slug, 'post_tag' );
	$tag_name = ( $tag_data ) ? $tag_data->name : $tag_slug;

	$searched_term = $searched_term ? $searched_term . ' / ' . $tag_name : $tag_name;
}

$searched_text = $searched_text ? $searched_text . ' ( ' . $searched_term . ' )' : $searched_term;

// translators: %s is the value of $searched_text.
$searched_text = sprintf( __( 'Search results for %s', 'arkhe' ), $searched_text );

// リストタイプ
$list_type = apply_filters( 'arkhe_list_type_on_search', ARKHE_LIST_TYPE );
?>
<main id="main_content" class="<?php Arkhe::main_class(); ?>">
	<div class="<?php Arkhe::main_body_class(); ?>">
		<?php do_action( 'arkhe_start_search_main_content' ); ?>
		<div class="p-archive__title c-pageTitle">
			<h1 class="c-pageTitle__main">
				<?php
					echo wp_kses(
						apply_filters( 'arkhe_search_title', $searched_text, $search_query, $cat_name, $tag_name ),
						\Arkhe::$allowed_text_html
					);
				?>
			</h1>
		</div>
		<?php
			// 投稿リスト前フック
			do_action( 'arkhe_before_search_post_list' );

			// 投稿一覧
			Arkhe::get_part( 'post_list/main_query', array( 'list_type' => $list_type ) );

			// ページャー
			the_posts_pagination(
				array(
					'mid_size'           => 2,
					'screen_reader_text' => null,
				)
			);
		?>
		<?php do_action( 'arkhe_end_search_main_content' ); ?>
	</div>
</main>
<?php get_footer(); ?>
