<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 「投稿ページ」に設定されたページ or ホームページに設定がない場合
 */
get_header();

$post_data = get_queried_object();
$the_id    = isset( $post_data->ID ) ? $post_data->ID : 0;
?>
<main id="main_content" class="<?php ARKHE_THEME::main_class(); ?>">
	<div class="<?php ARKHE_THEME::main_body_class(); ?>">
		<?php
			// ページタイトル
			if ( $the_id ) ARKHE_THEME::get_parts( 'page/header', array( 'post_id' => $the_id ) );

			// 投稿リストを表示
			ARKHE_THEME::get_parts( 'home_content' );
		?>
	</div>
</main>
<?php
get_footer();
