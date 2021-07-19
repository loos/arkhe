<?php
/**
 * 投稿ページのフッター部分
 */
$the_id    = get_the_ID();
$post_data = get_post( $the_id );

$show_foot_terms     = apply_filters( 'arkhe_show_show_foot_terms', Arkhe::get_setting( 'show_foot_terms' ), $the_id );
$show_prev_next_link = apply_filters( 'arkhe_show_show_prev_next_link', Arkhe::get_setting( 'show_prev_next_link' ), $the_id );
$show_author_box     = apply_filters( 'arkhe_show_author_box', Arkhe::get_setting( 'show_author_box' ), $the_id );
$show_related_posts  = apply_filters( 'arkhe_show_related_posts', Arkhe::get_setting( 'show_related_posts' ), $the_id );
?>
<footer class="p-entry__foot">
	<?php
		do_action( 'arkhe_start_entry_foot', $the_id );

		// メタ情報
		if ( $show_foot_terms ) :
			Arkhe::get_part( 'single/foot/meta' );
		endif;

		// 前の記事・次の記事
		if ( $show_prev_next_link ) :
			Arkhe::get_part( 'single/foot/prev_next_link' );
		endif;

		// 著者情報
		if ( $show_author_box ) :
			Arkhe::get_part( 'single/foot/post_author', array( 'author_id' => $post_data->post_author ) );
		endif;

		// 関連記事
		if ( $show_related_posts ) :
			Arkhe::get_part( 'single/foot/related_posts' );
		endif;

		do_action( 'arkhe_end_entry_foot', $the_id );
	?>
</footer>
