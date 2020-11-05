<?php
/**
 * ターム系以外のアーカイブページ
 */

// アーカイブページのデータ
$archive_data = Arkhe::get_archive_data();

// リストタイプ
$list_type = apply_filters( 'arkhe_list_type_on_archive', ARKHE_LIST_TYPE, $archive_data );
?>
<div <?php post_class( Arkhe::main_body_class( false ) ); ?>>
<?php
	// タイトル
	Arkhe::get_part( 'archive/title', $archive_data );

	// 投稿リスト前フック
	do_action( 'arkhe_before_archive_post_list' );

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
</div>
