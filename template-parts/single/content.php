<?php
/**
 * 投稿ページのコンテンツ部分
 */
$the_id = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();

// ヘッダーエリア
Arkhe::get_part( 'single/header', array( 'post_id' => $the_id ) );

// 記事前フック
do_action( 'arkhe_before_entry_content', $the_id );

?>
<div class="<?php Arkhe::post_content_class(); ?>">
	<?php the_content(); ?>
</div>
<?php

// 改ページナビゲーション
Arkhe::get_part( 'singular/pagination' );

// 記事後フック
do_action( 'arkhe_after_entry_content', $the_id );

// フッターエリア
Arkhe::get_part( 'single/footer', $the_id );

// コメントエリア
$show_comments = apply_filters( 'arkhe_show_entry_comments', Arkhe::get_setting( 'show_comments' ), $the_id );
if ( $show_comments && comments_open( $the_id ) && ! post_password_required( $the_id ) ) :
	comments_template();
endif;
