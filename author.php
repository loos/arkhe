<?php
/**
 * 著者アーカイブページ用テンプレート
 */
get_header();
$author_id   = get_queried_object_id();
$author_data = get_userdata( $author_id );

// リストタイプ
$list_type = apply_filters( 'arkhe_list_type_on_author', ARKHE_LIST_TYPE, $author_id );

?>
<main id="main_content" class="<?php Arkhe::main_class(); ?>">
	<div <?php post_class( Arkhe::main_body_class( false ) ); ?>>
		<?php do_action( 'arkhe_start_author_main_content', $author_id ); ?>
		<div class="p-archive__title c-pageTitle">
			<h1 class="c-pageTitle__main"><?php echo esc_html( $author_data->display_name ); ?></h1>
		</div>
		<?php
			// 著者情報
			Arkhe::get_part( 'others/author_box', array( 'author_id' => $author_id ) );

			// 投稿リスト前フック
			do_action( 'arkhe_before_author_post_list', $author_id );

			// 投稿リスト
			Arkhe::get_part( 'post_list/main_query', array( 'list_type' => $list_type ) );

			// ページャー
			the_posts_pagination(
				array(
					'mid_size'           => 2,
					'screen_reader_text' => null,
				)
			);
		?>
		<?php do_action( 'arkhe_end_author_main_content', $author_id ); ?>
	</div>
</main>
<?php get_footer(); ?>
