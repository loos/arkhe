<?php
/**
 * 投稿リスト著者アイコン
 */
$author_id   = isset( $args['author_id'] ) ? $args['author_id'] : 0;
$author_data = Arkhe::get_author_icon_data( $author_id );
?>
<div class="p-postList__author c-postAuthor u-flex--aic">
	<figure class="c-postAuthor__figure"><?php echo wp_kses( $author_data['avatar'], Arkhe::$allowed_img_html ); ?></figure>
	<span class="c-postAuthor__name u-color-thin"><?php echo esc_html( $author_data['name'] ); ?></span>
</div>
