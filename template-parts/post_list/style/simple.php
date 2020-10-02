<?php
/**
 * 投稿一覧リスト（ シンプル型 ）の出力テンプレート
 *
 * @param $args
 *   $args['count'] : 現在のループカウント数 (フック用に用意)
 */
$post_data = get_post();
$the_id    = $post_data->ID;

// メタデータ用テンプレに渡す配列
$args['post_id']   = $the_id;
$args['author_id'] = $post_data->post_author;
$args['date']      = new DateTime( $post_data->post_date );
$args['modified']  = new DateTime( $post_data->post_modified );
?>
<li class="p-postList__item">
	<a href="<?php the_permalink( $the_id ); ?>" class="p-postList__link">
		<div class="p-postList__body">
			<?php Arkhe::get_parts( 'post_list/item/meta', $args ); ?>
			<div class="p-postList__title"><?php the_title(); ?></div>
		</div>
	</a>
</li>
