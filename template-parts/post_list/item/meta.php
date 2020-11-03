<?php
/**
 * 投稿リストに表示されるメタデータ
 *
 * 渡されるプロパティ
 *   $args['post_id'] : 投稿ID
 *   $args['author_id'] : 著者ID
 *   $args['date'] : 公開日
 *   $args['modified'] : 更新日
 *
 * 渡される可能性のあるプロパティ
 *   $args['show_cat'] : カテゴリーを表示するかどうか
 *   $args['show_date'] : 公開日を表示するかどうか
 *   $args['show_modified'] : 更新日を表示するかどうか
 *   $args['show_author'] : 著者を表示するかどうか
 */
$setting = \Arkhe::get_setting();

// 投稿データ
$the_id    = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$author_id = isset( $args['author_id'] ) ? $args['author_id'] : 0;
$date      = isset( $args['date'] ) ? $args['date'] : null;
$modified  = isset( $args['modified'] ) ? $args['modified'] : null;

// リスト用の設定データ
$show_cat      = isset( $args['show_cat'] ) ? $args['show_cat'] : $setting['show_list_cat'];
$show_date     = isset( $args['show_date'] ) ? $args['show_date'] : $setting['show_list_date'];
$show_modified = isset( $args['show_modified'] ) ? $args['show_modified'] : $setting['show_list_mod'];
$show_author   = isset( $args['show_author'] ) ? $args['show_author'] : $setting['show_list_author'];

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
<div class="p-postList__meta c-postMetas u-flex--aicw">
	<?php if ( $show_date || $show_modified ) : ?>
		<div class="p-postList__times c-postTimes u-color-thin u-flex--aic">
			<?php
				if ( $show_date && $date ) :
					Arkhe::the_date_time( $date, 'posted' );
				endif;

				if ( $show_modified && $modified ) :
					Arkhe::the_date_time( $modified, 'modified' );
				endif;
			?>
		</div>
	<?php endif; ?>
	<?php if ( $show_cat && $cat_data ) : ?>
		<div class="p-postList__cat u-color-thin u-flex--aic" data-cat-id="<?php echo esc_attr( $cat_data->term_id ); ?>">
		<i class="c-postMetas__icon arkhe-icon-folder" role="img" aria-hidden="true"></i>
		<?php echo esc_html( $cat_data->name ); ?></div>
	<?php endif; ?>
	<?php if ( $show_author && $author_data ) : ?>
		<div class="p-postList__author c-postAuthor u-flex--aic">
			<figure class="c-postAuthor__figure">
				<?php echo get_avatar( $author_id, 100, '', '' ); ?>
			</figure>
			<span class="c-postAuthor__name u-color-thin"><?php echo esc_html( $author_data->display_name ); ?></span>
		</div>
	<?php endif; ?>
</div>
