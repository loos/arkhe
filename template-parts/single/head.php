<?php
/**
 * 投稿ページのタイトル部分
 * $args['post_id'] : 投稿IDが渡ってくる
 */
$setting = Arkhe::get_setting();

$the_id    = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$post_data = get_post( $the_id );
$date      = new DateTime( $post_data->post_date );
$modified  = new DateTime( $post_data->post_modified );

// 公開日 < 更新日かどうか
$is_modified = ( $date < $modified );

$show_thumb = apply_filters( 'arkhe_show_entry_thumb', Arkhe::get_setting( 'show_entry_thumb' ), $the_id );

?>
<header class="p-entry__head">
	<?php if ( ! Arkhe::is_show_ttltop() ) : ?>
		<div class="p-entry__title c-pageTitle">
			<h1 class="c-pageTitle__main"><?php the_title(); ?></h1>
		</div>
	<?php endif; ?>
	<div class="c-postMetas u-flex--aicw">
		<div class="c-postTimes u-flex--aicw">
			<?php
				\Arkhe::the_pluggable_part( 'post_time', array(
					'date' => $date,
					'type' => 'posted',
					'tag'  => 'time',
				) );
				if ( $is_modified ) :
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
				'post_id'  => $the_id,
				'show_cat' => $setting['show_entry_cat'],
				'show_tag' => $setting['show_entry_tag'],
				'is_head'  => true,
			) );

			// 著者アイコン
			if ( $setting['show_entry_author'] ) :
				$author_icon = Arkhe::get_author_icon_data( $post_data->post_author );
			?>
				<a href="<?php echo esc_url( $author_icon['url'] ); ?>" class="c-postAuthor u-flex--aic">
					<figure class="c-postAuthor__figure"><?php echo wp_kses( $author_icon['avatar'], Arkhe::$allowed_img_html ); ?></figure>
					<span class="c-postAuthor__name"><?php echo esc_html( $author_icon['name'] ); ?></span>
				</a>
			<?php endif; ?>
	</div>
	<?php
		// アイキャッチ画像
		if ( $show_thumb ) :
			Arkhe::get_part( 'single/item/thumbnail', array(
				'post_id'    => $the_id,
				'post_title' => $post_data->post_title,
			) );
		endif;
	?>
</header>
