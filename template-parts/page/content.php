<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 固定ページのコンテンツ部分
 */
$the_id = get_the_ID();

// ヘッダー部分
ARKHE_THEME::get_parts( 'page/header', array( 'post_id' => $the_id ) );

// コンテンツ前フック
do_action( 'arkhe_before_page_content', $the_id );

?>
<div class="<?php ARKHE_THEME::post_content_class(); ?>">
	<?php the_content(); ?>
</div>
<?php

// 改ページナビゲーション
ARKHE_THEME::get_parts( 'singular/pagination' );

// コンテンツ後フック
do_action( 'arkhe_after_page_content', $the_id );

// コメント
if ( comments_open( $the_id ) && ! post_password_required( $the_id ) ) :
	comments_template();
endif;
