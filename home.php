<?php
/**
 * 「投稿ページ」に設定されたページ or ホームページに指定がない場合のトップページ
 */
get_header();

$post_data = get_queried_object();
$the_id    = isset( $post_data->ID ) ? $post_data->ID : 0;
?>
<main id="main_content" class="<?php Arkhe::main_class(); ?>">
	<div class="<?php Arkhe::main_body_class(); ?>">
		<?php
			// ページタイトル
			if ( $the_id ) Arkhe::get_part( 'page/header', array( 'post_id' => $the_id ) );

			// 投稿リストを表示
			Arkhe::get_part( 'home_content' );
		?>
	</div>
</main>
<?php
get_footer();
