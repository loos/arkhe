<?php
/**
 * 投稿メタ（head）
 */
$show_posted   = Arkhe::get_setting( 'show_entry_posted' );
$show_modified = Arkhe::get_setting( 'show_entry_modified' );
$show_cat      = Arkhe::get_setting( 'show_entry_cat' );
$show_tag      = Arkhe::get_setting( 'show_entry_tag' );
$show_tax      = Arkhe::get_setting( 'show_entry_custom_tax' );
$show_author   = Arkhe::get_setting( 'show_entry_author' );

$post_data          = get_post();
$the_id             = $post_data->ID;
$author_id          = $post_data->post_author;
$date_timestamp     = get_post_timestamp( $the_id, 'date' );
$modified_timestamp = get_post_timestamp( $the_id, 'modified' );

// 更新日が公開日より遅い場合だけ表示（ただし、更新日だけ表示の時は更新日をそのまま表示する）
if ( $show_modified && $show_posted ) {
	$show_modified = ( $date_timestamp < $modified_timestamp ) ? $show_modified : false;
}

?>
<div class="c-postMetas u-flex--aicw">
	<div class="c-postTimes u-flex--aicw">
		<?php
			if ( $show_posted ) ark_the__postdate( $date_timestamp, 'posted' );
			if ( $show_modified ) ark_the__postdate( $modified_timestamp, 'modified' );
		?>
	</div>
	<?php
		// カテゴリー・タグ
		Arkhe::get_part( 'single/item/term_list', array(
			'show_cat' => $show_cat,
			'show_tag' => $show_tag,
			'show_tax' => $show_tax,
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
