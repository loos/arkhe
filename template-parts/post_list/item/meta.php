<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿リストに表示されるメタデータ
 *
  * 渡されるプロパティ
 *   $parts_args['post_id'] : 投稿ID
 *   $parts_args['author_id'] : 著者ID
 *   $parts_args['date'] : 公開日
 *   $parts_args['modified'] : 更新日
 *
 * 渡される可能性のあるプロパティ
 *   $parts_args['show_cat'] : カテゴリーを表示するかどうか
 *   $parts_args['show_date'] : 公開日を表示するかどうか
 *   $parts_args['show_modified'] : 更新日を表示するかどうか
 *   $parts_args['show_author'] : 著者を表示するかどうか
 */
$SETTING = \ARKHE_THEME::get_setting();

// 投稿データ
$the_id    = isset( $parts_args['post_id'] ) ? $parts_args['post_id'] : get_the_ID();
$author_id = isset( $parts_args['author_id'] ) ? $parts_args['author_id'] : 0;
$date      = isset( $parts_args['date'] ) ? $parts_args['date'] : null;
$modified  = isset( $parts_args['modified'] ) ? $parts_args['modified'] : null;

// リスト用の設定データ
$show_cat      = isset( $parts_args['show_cat'] ) ? $parts_args['show_cat'] : $SETTING['show_list_cat'];
$show_date     = isset( $parts_args['show_date'] ) ? $parts_args['show_date'] : $SETTING['show_list_date'];
$show_modified = isset( $parts_args['show_modified'] ) ? $parts_args['show_modified'] : $SETTING['show_list_mod'];
$show_author   = isset( $parts_args['show_author'] ) ? $parts_args['show_author'] : $SETTING['show_list_author'];

// 更新日は、公開日より遅い場合だけ表示
if ( $show_modified && $show_date ) {
	$show_modified = ( $date < $modified ) ? $show_modified : false;
}

// カテゴリーデータ
$cat_data = get_the_category( $the_id );
$cat_data = empty( $cat_data ) ? null : $cat_data[0];

// 著者データ
$author_data = get_userdata( $author_id );

?>
<div class="p-postList__meta">
	<?php if ( $show_date || $show_modified ) : ?>
		<div class="p-postList__times c-postTimes u-color-thin">
			<?php
				if ( $show_date && $date ) :
				ARKHE_THEME::the_date_time( $date, 'posted' );
				endif;

				if ( $show_modified && $modified ) :
				ARKHE_THEME::the_date_time( $modified, 'modified' );
				endif;
			?>
		</div>
	<?php endif; ?>
	<?php
		if ( $show_cat && $cat_data ) :
			echo '<span class="p-postList__cat u-color-thin" data-cat-id="' . esc_attr( $cat_data->term_id ) . '">' .
				esc_html( $cat_data->name ) .
			'</span>';
		endif;
	?>
	<?php if ( $show_author && $author_data ) : ?>
		<div class="p-postList__author c-postAuthor">
			<figure class="c-postAuthor__figure">
				<?php echo get_avatar( $author_id, 100, '', '' ); ?>
			</figure>
			<span class="c-postAuthor__name u-color-thin"><?php echo esc_html( $author_data->display_name ); ?></span>
		</div>
	<?php endif; ?>
</div>
