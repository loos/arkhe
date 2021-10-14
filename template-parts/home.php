<?php
/**
 * 「最新の投稿」 or 「投稿一覧」 のコンテンツ
 *   front-page.php と home.php から呼ばれることに注意。
 */

// 「投稿ページ」に設定された固定ページの場合
if ( ! is_front_page() ) {
	$page_obj     = get_queried_object();
	$page_content = $page_obj->post_content;

	if ( ! empty( $page_content ) ) {

		// the_content()を参考: https://core.trac.wordpress.org/browser/tags/5.8/src/wp-includes/post-template.php#L243
		$page_content = apply_filters( 'the_content', $page_content );
		$page_content = str_replace( ']]>', ']]&gt;', $page_content );

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<div class="' . esc_attr( Arkhe::get_post_content_class() ) . '">' . $page_content . '</div>';
	}
}

// 投稿一覧
Arkhe::get_part( 'post_list/main_query', array(
	'list_type' => apply_filters( 'arkhe_list_type_on_home', ARKHE_LIST_TYPE ),
) );

// ページャー
the_posts_pagination( array(
	'mid_size' => 2,
	// 'screen_reader_text' => 'ページネーション',
) );
