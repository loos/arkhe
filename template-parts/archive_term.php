<?php
/**
 * タームアーカイブページ
 */
$term_obj         = get_queried_object();
$term_id          = $term_obj->term_id;
$term_description = apply_filters( 'arkhe_term_description', $term_obj->description, $term_id );
$show_description = apply_filters( 'arkhe_show_term_description', ! empty( $term_description ), $term_id );

// タイトル部分
if ( ! Arkhe::is_show_ttltop() ) {
	Arkhe::get_part( 'archive/title' );

	// 説明文
	if ( $show_description ) {
		echo '<div class="p-archive__desc">' . do_shortcode( $term_description ) . '</div>';
	}
}

// 投稿リスト前フック
do_action( 'arkhe_before_term_post_list', $term_id );

// 投稿リスト
Arkhe::get_part( 'post_list/main_query', array(
	'list_type' => apply_filters( 'arkhe_list_type_on_term', ARKHE_LIST_TYPE, $term_id ),
) );

// ページャー
the_posts_pagination( array( 'mid_size' => 2 ) );
