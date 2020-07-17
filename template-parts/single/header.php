<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿ページのタイトル部分
 * $parts_args['post_id'] : 投稿IDが渡ってくる
 */
$SETTING = ARKHE_THEME::get_setting();

$the_id    = isset( $parts_args['post_id'] ) ? $parts_args['post_id'] : get_the_ID();
$post_data = get_post( $the_id );
$date      = new DateTime( $post_data->post_date );
$modified  = new DateTime( $post_data->post_modified );

// 公開日 < 更新日かどうか
$is_modified = ( $date < $modified );

// シェアボタンを表示するかどうか
// $show_share_btn = apply_filters( 'arkhe_show_share_btn', $SETTING['show_share_btn_top'] );
?>
<header class="p-entry__head">
	<h1 class="p-entry__title c-pageTitle"><?php the_title(); ?></h1>
	<div class="p-entry__head__meta">
		<div class="c-postTimes">
			<?php ARKHE_THEME::the_date_time( $date, 'posted' ); ?>
			<?php
				if ( $is_modified ) :
					ARKHE_THEME::the_date_time( $modified, 'modified', false );
				endif;
			?>
		</div>
		<?php
			// カテゴリー・タグ
			ARKHE_THEME::get_parts(
				'single/term_list',
				array(
					'post_id'  => $the_id,
					'show_cat' => $SETTING['show_entry_cat'],
					'show_tag' => $SETTING['show_entry_tag'],
				)
			);

			// 著者アイコン
			if ( $SETTING['show_entry_author'] ) :
				$author_id   = $post_data->post_author;
				$author_data = get_userdata( $author_id );
				$author_url  = get_author_posts_url( $author_id );
			?>
				<a href="<?php echo esc_url( $author_url ); ?>" class="c-postAuthor">
					<figure class="c-postAuthor__figure">
						<?php echo get_avatar( $author_id, 100, '', '' ); ?>
					</figure>
					<span class="c-postAuthor__name"><?php echo esc_html( $author_data->display_name ); ?></span>
				</a>
			<?php endif; ?>
	</div>
	<?php
		// アイキャッチ画像
		if ( ARKHE_THEME::get_setting( 'show_entry_thumb' ) ) :
			ARKHE_THEME::get_parts(
				'singular/thumbnail',
				array(
					'post_id'    => $the_id,
					'post_title' => $post_data->post_title,
				)
			);
		endif;
	?>
</header>

<?php

// 記事上シェアボタン
// if ( $show_share_btn ) :
// 	ARKHE_THEME::get_parts( 'single/share_btns', array( 'post_id' => $the_id ) );
// endif;
