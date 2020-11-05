<?php
/**
 * 「最新の投稿」 or 「投稿一覧」 のページ用
 */

// リストタイプ
$list_type = apply_filters( 'arkhe_list_type_on_home', ARKHE_LIST_TYPE );

// コンテンツ前フック
do_action( 'arkhe_before_home_content' );

// 投稿一覧
Arkhe::get_part( 'post_list/main_query', array( 'list_type' => $list_type ) );

// ページャー
the_posts_pagination(
	array(
		'mid_size'           => 2,
		'screen_reader_text' => null,
	)
);

// コンテンツ後フック
do_action( 'arkhe_after_home_content' );
