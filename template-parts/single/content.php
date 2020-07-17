<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿ページのタイトル部分
 */
$the_id = get_the_ID();

// ヘッダーエリア
ARKHE_THEME::get_parts( 'single/header', array( 'post_id' => $the_id ) );

// 記事前フック
do_action( 'arkhe_before_entry_content', $the_id );

?>
<div class="<?php ARKHE_THEME::post_content_class(); ?>">
	<?php the_content(); ?>
</div>
<?php

// 改ページナビゲーション
ARKHE_THEME::get_parts( 'singular/pagination' );

// 記事後フック
do_action( 'arkhe_after_entry_content', $the_id );

// フッターエリア
ARKHE_THEME::get_parts( 'single/footer', $the_id );

// コメントエリア
$show_comments = apply_filters( 'arkhe_show_post_comments', ARKHE_THEME::get_setting( 'show_comments' ) );
if ( $show_comments && comments_open( $the_id ) && ! post_password_required( $the_id ) ) :
	comments_template();
endif;
