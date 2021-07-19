<?php
/**
 * 通常アーカイブページ
 */

// タイトル
Arkhe::get_part( 'archive/title' );

// 投稿リスト前フック
do_action( 'arkhe_before_archive_post_list' );

// 投稿リスト
Arkhe::get_part( 'post_list/main_query', array(
	'list_type' => apply_filters( 'arkhe_list_type_on_archive', ARKHE_LIST_TYPE, Arkhe::get_archive_data( 'type' ) ),
) );

// ページャー
the_posts_pagination( array( 'mid_size' => 2 ) );
