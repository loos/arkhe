<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿ページのフッター部分
 * $args['post_id'] : 投稿IDが渡ってくる
 */
$SETTING = ARKHE_THEME::get_setting();

// 投稿情報
$the_id    = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$post_data = get_post( $the_id );

// シェアボタンを表示するかどうか
// $show_share_btn = apply_filters( 'arkhe_show_share_btn', $SETTING['show_share_btn_bottom'] );

// 記事上ウィジェットを表示するか
$show_widget_bottom = apply_filters( 'arkhe_show_widget_single_bottom', is_active_sidebar( 'single_bottom' ) );

// 著者情報を表示するか
$show_author_box = apply_filters( 'arkhe_show_author_box', $SETTING['show_author_box'] );

// 関連記事を表示するか
$show_related_posts = apply_filters( 'arkhe_show_related_posts', $SETTING['show_related_posts'] );


// 下部シェアボタン
// if ( $show_share_btn ) :
// if ( 1 ) :
// 	ARKHE_THEME::get_parts( 'single/share_btns', array( 'post_id' => $the_id ) );
// endif;

?>
<footer class="p-entry__foot">
	<div class="p-entry__foot__meta">
		<?php
		ARKHE_THEME::get_parts(
			'single/term_list',
			array(
				'post_id'  => $the_id,
				'show_cat' => true,
				'show_tag' => true,
			)
		);
		?>
	</div>
	<?php

		// 前の記事・次の記事
		if ( $SETTING['show_page_links'] ) :
		ARKHE_THEME::get_parts( 'single/prev_next_link' );
		endif;

		// 著者情報
		if ( $show_author_box ) :
		ARKHE_THEME::get_parts( 'single/post_author', array( 'author_id' => $post_data->post_author ) );
		endif;

		// 関連記事
		if ( $show_related_posts ) :
		ARKHE_THEME::get_parts( 'single/related_posts', $the_id );
		endif;
	?>
</footer>
