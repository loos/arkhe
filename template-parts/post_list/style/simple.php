<?php
/**
 * 投稿一覧リスト（ シンプル型 ）の出力テンプレート
 *
 * @param $args
 *   $args['count'] : 現在のループカウント数 (フック用に用意)
 */
$post_data  = get_post();
$the_id     = $post_data->ID;
$h_tag      = isset( $args['h_tag'] ) ? $args['h_tag'] : 'h2';
$list_class = isset( $args['list_class'] ) ? $args['list_class'] : '';
$list_class = $list_class ? 'p-postList__item ' . $list_class : 'p-postList__item';

// メタデータ用テンプレに渡す配列
$args['post_id']   = $the_id;
$args['author_id'] = $post_data->post_author;
$args['date']      = new DateTime( $post_data->post_date );
$args['modified']  = new DateTime( $post_data->post_modified );
?>
<li class="<?php echo esc_attr( $list_class ); ?>">
	<a href="<?php the_permalink( $the_id ); ?>" class="p-postList__link">
		<div class="p-postList__body">
			<?php Arkhe::get_part( 'post_list/item/meta', $args ); ?>
			<?php
				echo '<' . esc_attr( $h_tag ) . ' class="p-postList__title">';
				the_title();
				echo '</' . esc_attr( $h_tag ) . '>';
			?>
		</div>
	</a>
</li>
