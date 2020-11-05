<?php
/**
 * 投稿一覧リストの出力テンプレート
 *
 * @param $args
 *   $args['count'] : 現在のループカウント数 (フック用に用意)
 */
$list_type  = isset( $args['list_type'] ) ? $args['list_type'] : ARKHE_LIST_TYPE;
$h_tag      = isset( $args['h_tag'] ) ? $args['h_tag'] : 'h2';
$list_class = isset( $args['list_class'] ) ? $args['list_class'] : '';
$list_class = $list_class ? 'p-postList__item ' . $list_class : 'p-postList__item';

// 投稿情報
$post_data = get_post();
$the_id    = $post_data->ID;

// メタデータ用テンプレに渡す配列
$args['post_id']   = $the_id;
$args['author_id'] = $post_data->post_author;
$args['date']      = new DateTime( $post_data->post_date );
$args['modified']  = new DateTime( $post_data->post_modified );

?>
<li class="<?php echo esc_attr( $list_class ); ?>">
	<a href="<?php the_permalink( $the_id ); ?>" class="p-postList__link">
		<?php
			Arkhe::get_part(
				'post_list/item/thumb',
				array(
					'post_id'   => $the_id,
					'list_type' => $list_type,
				)
			);
		?>
		<div class="p-postList__body">
			<?php
				echo '<' . esc_attr( $h_tag ) . ' class="p-postList__title">';
				the_title();
				echo '</' . esc_attr( $h_tag ) . '>';
			?>
			<?php if ( \Arkhe::$excerpt_length ) : ?>
				<div class="p-postList__excerpt u-thin">
					<?php the_excerpt(); ?>
				</div>
			<?php endif; ?>
			<?php Arkhe::get_part( 'post_list/item/meta', $args ); ?>
		</div>
	</a>
</li>
