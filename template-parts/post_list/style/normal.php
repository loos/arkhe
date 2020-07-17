<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿一覧リストの出力テンプレート
 *
 * @param $parts_args
 *   $parts_args['count'] : 現在のループカウント数 (フック用に用意)
 */
$list_type = isset( $parts_args['type'] ) ? $parts_args['type'] : POST_LIST_TYPE;

// 投稿情報
$post_data = get_post();
$the_id    = $post_data->ID;

// メタデータ用テンプレに渡す配列
$parts_args['post_id']   = $the_id;
$parts_args['author_id'] = $post_data->post_author;
$parts_args['date']      = new DateTime( $post_data->post_date );
$parts_args['modified']  = new DateTime( $post_data->post_modified );
?>
<li class="p-postList__item">
	<a href="<?php the_permalink( $the_id ); ?>" class="p-postList__link">
		<?php
			ARKHE_THEME::get_parts(
				'post_list/item/thumb',
				array(
					'post_id'   => $the_id,
					'list_type' => $list_type,
				)
			);
		?>
		<div class="p-postList__body">
			<h2 class="p-postList__title"><?php the_title(); ?></h2>
			<?php if ( 0 !== ARKHE_EXCERPT_LENGTH ) : ?>
				<div class="p-postList__excerpt u-thin">
					<?php the_excerpt(); ?>
				</div>
			<?php endif; ?>
			<?php ARKHE_THEME::get_parts( 'post_list/item/meta', $parts_args ); ?>
		</div>
	</a>
</li>
