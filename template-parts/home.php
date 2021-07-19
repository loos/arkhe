<?php
/**
 * 「最新の投稿」 or 「投稿一覧」 のコンテンツ
 *   front-page.php と home.php から呼ばれることに注意。
 */

// 投稿一覧
Arkhe::get_part( 'post_list/main_query', array(
	'list_type' => apply_filters( 'arkhe_list_type_on_home', ARKHE_LIST_TYPE ),
) );

// ページャー
the_posts_pagination( array(
	'mid_size' => 2,
	// 'screen_reader_text' => 'ページネーション',
) );
