<?php
/**
 * 投稿ページのコメント
 */
$the_id = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();

$show_comments = apply_filters( 'arkhe_show_entry_comments', Arkhe::get_setting( 'show_comments' ), $the_id );
if ( $show_comments && comments_open( $the_id ) && ! post_password_required( $the_id ) ) :
	comments_template();
endif;
