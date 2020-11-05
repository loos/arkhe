<?php
/**
 * ターム用アーカイブページ
 */

$wp_obj  = get_queried_object();
$term_id = $wp_obj->term_id;

// リストタイプ
$list_type = apply_filters( 'arkhe_list_type_on_term', ARKHE_LIST_TYPE, $term_id );

// アーカイブページのデータ
$archive_data = Arkhe::get_archive_data();

// 説明文
$term_description = $wp_obj->description;

if ( ! Arkhe::is_show_ttltop() ) :
	Arkhe::get_part( 'archive/title', $archive_data );
endif;
if ( ! empty( $term_description ) ) :
?>
	<div class="p-archive__desc"><?php echo do_shortcode( $term_description ); ?></div>
<?php
endif;

// 投稿リスト前フック
do_action( 'arkhe_before_term_post_list', $term_id );

// 投稿リスト
Arkhe::get_part( 'post_list/main_query', array( 'list_type' => $list_type ) );

// ページャー
the_posts_pagination(
	array(
		'mid_size'           => 2,
		'screen_reader_text' => null,
	)
);
