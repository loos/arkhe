<?php
/**
 * 投稿一覧リスト（ シンプル型 ）の出力テンプレート
 *
 * @param $args
 *   $args['count'] : 現在のループカウント数 (フック用に用意)
 */
$h_tag         = isset( $args['h_tag'] ) ? $args['h_tag'] : 'h2';
$list_class    = isset( $args['list_class'] ) ? $args['list_class'] : '';
$show_date     = isset( $args['show_date'] ) ? $args['show_date'] : Arkhe::get_setting( 'show_list_date' );
$show_modified = isset( $args['show_modified'] ) ? $args['show_modified'] : Arkhe::get_setting( 'show_list_mod' );
$show_cat      = isset( $args['show_cat'] ) ? $args['show_cat'] : Arkhe::get_setting( 'show_list_cat' );
$show_author   = isset( $args['show_author'] ) ? $args['show_author'] : Arkhe::get_setting( 'show_list_author' );

// 投稿データ取得
$post_data = get_post();
?>
<li class="<?php echo esc_attr( trim( 'p-postList__item ' . $list_class ) ); ?>">
	<a href="<?php the_permalink(); ?>" class="p-postList__link">
		<div class="p-postList__body">
			<?php
				Arkhe::get_part( 'post_list/item/meta', array(
					'date'          => $show_date ? $post_data->post_date : null,
					'modified'      => $show_modified ? $post_data->post_modified : null,
					'author_id'     => $show_author ? $post_data->post_author : 0,
					'show_cat'      => $show_cat,
				) );

				echo '<' . esc_attr( $h_tag ) . ' class="p-postList__title">';
				the_title();
				echo '</' . esc_attr( $h_tag ) . '>';
			?>
		</div>
	</a>
</li>
