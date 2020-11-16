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

?>
<header class="p-entry__head">
	<?php if ( ! Arkhe::is_show_ttltop() ) : ?>
		<div class="p-entry__title c-pageTitle">
			<h1 class="c-pageTitle__main"><?php the_title(); ?></h1>
		</div>
	<?php endif; ?>
	<div class="c-postMetas u-flex--aicw">
		<div class="c-postTimes u-flex--aicw">
			<?php Arkhe::the_date_time( $date, 'posted' ); ?>
			<?php
				if ( $is_modified ) :
					Arkhe::the_date_time( $modified, 'modified', false );
				endif;
			?>
		</div>
		<?php
			// カテゴリー・タグ
			Arkhe::get_part(
				'single/term_list',
				array(
					'post_id'  => $the_id,
					'show_cat' => $setting['show_entry_cat'],
					'show_tag' => $setting['show_entry_tag'],
					'is_head'  => true,
				)
			);

			// 著者アイコン
			if ( $setting['show_entry_author'] ) :
				$author_id   = $post_data->post_author;
				$author_data = get_userdata( $author_id );
				$author_url  = get_author_posts_url( $author_id );
			?>
				<a href="<?php echo esc_url( $author_url ); ?>" class="c-postAuthor u-flex--aic">
					<figure class="c-postAuthor__figure">
						<?php echo get_avatar( $author_id, 100, '', '' ); ?>
					</figure>
					<span class="c-postAuthor__name"><?php echo esc_html( $author_data->display_name ); ?></span>
				</a>
			<?php endif; ?>
	</div>
	<?php
		// アイキャッチ画像
		$show_thumb = apply_filters( 'arkhe_show_entry_thumb', Arkhe::get_setting( 'show_entry_thumb' ), $the_id );
		if ( $show_thumb ) :
			Arkhe::get_part(
				'singular/thumbnail',
				array(
					'post_id'    => $the_id,
					'post_title' => $post_data->post_title,
				)
			);
		endif;
	?>
</header>
