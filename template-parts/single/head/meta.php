<?php
/**
 * 投稿メタ（head）
 */
$post_data = get_post();
$date      = new DateTime( $post_data->post_date );
$modified  = new DateTime( $post_data->post_modified );
$author_id = $post_data->post_author;

$show_cat    = Arkhe::get_setting( 'show_entry_cat' );
$show_tag    = Arkhe::get_setting( 'show_entry_tag' );
$show_author = Arkhe::get_setting( 'show_entry_author' );
?>
<div class="c-postMetas u-flex--aicw">
	<div class="c-postTimes u-flex--aicw">
		<?php
			\Arkhe::the_pluggable_part( 'post_time', array(
				'date' => $date,
				'type' => 'posted',
				'tag'  => 'time',
			) );
			if ( $date < $modified ) :
				\Arkhe::the_pluggable_part( 'post_time', array(
					'date' => $modified,
					'type' => 'modified',
					'tag'  => 'time',
				) );
			endif;
		?>
	</div>
	<?php
		// カテゴリー・タグ
		Arkhe::get_part( 'single/item/term_list', array(
			'show_cat' => $show_cat,
			'show_tag' => $show_tag,
			'is_head'  => true,
		) );

		// 著者アイコン
		if ( $show_author && $author_id ) :
			$author_icon = Arkhe::get_author_icon_data( $author_id );
			echo '<a href="' . esc_url( $author_icon['url'] ) . '" class="c-postAuthor u-flex--aic">
					<figure class="c-postAuthor__figure">' . wp_kses( $author_icon['avatar'], Arkhe::$allowed_img_html ) . '</figure>
					<span class="c-postAuthor__name">' . esc_html( $author_icon['name'] ) . '</span>
				</a>';
		endif;
	?>
</div>
