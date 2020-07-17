<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 投稿一覧リスト（ シンプル型 ）の出力テンプレート
 *
 * @param $parts_args
 *   $parts_args['count'] : 現在のループカウント数 (フック用に用意)
 */

// 投稿情報
$post_data = get_post();
$post_id   = $post_data->ID;

// メタデータ用テンプレに渡す配列
$parts_args['post_id']   = $post_id;
$parts_args['author_id'] = $post_data->post_author;
$parts_args['date']      = new DateTime( $post_data->post_date );
$parts_args['modified']  = new DateTime( $post_data->post_modified );

?>
<li class="p-postList__item">
	<a href="<?php the_permalink( $post_id ); ?>" class="p-postList__link">
		<div class="p-postList__body">
			<?php ARKHE_THEME::get_parts( 'post_list/item/meta', $parts_args ); ?>
			<div class="p-postList__title"><?php the_title(); ?></div>
		</div>
	</a>
</li>
