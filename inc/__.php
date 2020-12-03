<?php
/**
 * 著者アイコンを表示する
 */
if ( ! function_exists( 'ark_the__author_icon' ) ) {
	function ark_the__author_icon( $author_id ) {

		// 情報取得
		$author_data = get_userdata( $author_id, $add_class = '', $is_link = false );
		if ( ! $author_data ) return;

		// 情報整理
		$author_name = $author_data->display_name;
		$author_url  = $is_link ? get_author_posts_url( $author_id ) : '';
		$class_name  = trim( 'c-postAuthor u-flex--aic ' . $add_class );

		if ( $author_url ) {
			echo '<a href="' . esc_url( $author_url ) . '" class="' . esc_attr( $class_name ) . '">' .
				'<figure class="c-postAuthor__figure">' . get_avatar( $author_id, 100, '', '' ) . '</figure>' .
				'<span class="c-postAuthor__name">' . esc_html( $author_name ) , '</span>' .
			'</a>';
		} else {
			echo '<div class="' . esc_attr( $class_name ) . '">' .
				'<figure class="c-postAuthor__figure">' . get_avatar( $author_id, 100, '', '' ) . '</figure>' .
				'<span class="c-postAuthor__name">' . esc_html( $author_name ) , '</span>' .
			'</div>';
		}

	}
}
