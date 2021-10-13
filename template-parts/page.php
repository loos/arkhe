<?php
/**
 * 固定ページのコンテンツ部分
 */
$the_id = get_the_ID();

// ヘッダー部分
if ( ! Arkhe::is_show_ttltop() ) {
	Arkhe::get_part( 'page/title' );
}

// コンテンツ前フック
do_action( 'arkhe_before_page_content', $the_id );

// コンテンツ
echo '<div class="' . esc_attr( Arkhe::get_post_content_class() ) . '">';
	the_content();
echo '</div>';

// 改ページナビゲーション
Arkhe::get_part( 'other/pagination' );

// コンテンツ後フック
do_action( 'arkhe_after_page_content', $the_id );

// コメント
if ( Arkhe::is_show_comments() ) comments_template();
