<?php
/**
 * 投稿ページのコンテンツ部分
 */
$the_id = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();

// ヘッダーエリア
Arkhe::get_part( 'single/head', array( 'post_id' => $the_id ) );

// 記事前フック
do_action( 'arkhe_before_entry_content', $the_id );

// コンテンツ
echo '<div class="' . esc_attr( Arkhe::get_post_content_class() ) . '">';
	the_content();
echo '</div>';

// 改ページナビゲーション
Arkhe::get_part( 'other/pagination' );

// 記事後フック
do_action( 'arkhe_after_entry_content', $the_id );

// フッターエリア
Arkhe::get_part( 'single/foot', array( 'post_id' => $the_id ) );

// コメントエリア
Arkhe::get_part( 'single/comment', array( 'post_id' => $the_id ) );
