<?php
/**
 * 投稿ページのフッター部分
 * $args['post_id'] : 投稿IDが渡ってくる
 */
$setting = Arkhe::get_setting();

// 投稿情報
$the_id    = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$post_data = get_post( $the_id );

// 本文下のターム情報を表示するかどうか
$show_foot_terms = apply_filters( 'arkhe_show_show_foot_terms', $setting['show_foot_terms'], $the_id );

// 前の記事・次の記事を表示するか
$show_prev_next_link = apply_filters( 'arkhe_show_show_prev_next_link', $setting['show_prev_next_link'], $the_id );

// 著者情報を表示するか
$show_author_box = apply_filters( 'arkhe_show_author_box', $setting['show_author_box'], $the_id );

// 関連記事を表示するか
$show_related_posts = apply_filters( 'arkhe_show_related_posts', $setting['show_related_posts'], $the_id );

?>
<footer class="p-entry__foot">
	<?php do_action( 'arkhe_start_entry_foot', $the_id ); ?>
	<?php if ( $show_foot_terms ) : ?>
		<div class="c-postMetas u-flex--aicw">
			<?php
				Arkhe::get_part(
					'single/term_list',
					array(
						'post_id'  => $the_id,
						'show_cat' => true,
						'show_tag' => true,
						'is_head'  => false,
					)
				);
			?>
		</div>
	<?php endif; ?>
	<?php

		// 前の記事・次の記事
		if ( $show_prev_next_link ) :
			Arkhe::get_part( 'single/prev_next_link' );
		endif;

		// 著者情報
		if ( $show_author_box ) :
			Arkhe::get_part( 'single/post_author', array( 'author_id' => $post_data->post_author ) );
		endif;

		// 関連記事
		if ( $show_related_posts ) :
			Arkhe::get_part( 'single/related_posts', $the_id );
		endif;

		do_action( 'arkhe_end_entry_foot', $the_id );
	?>
</footer>
