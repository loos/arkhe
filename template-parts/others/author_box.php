<?php
/**
 * 著者情報を出力する
 *   $args['author_id'] : 著者ID
 */
$author_id = isset( $args['author_id'] ) ? $args['author_id'] : 0;

// 著者データを取得
$author_data = get_userdata( $author_id );
if ( ! $author_data ) return;

// ユーザーデータ
$author_name = $author_data->display_name;
$description = $author_data->description;

$the_user_link_url = $author_data->user_url;
?>
<div class="p-authorBox">
	<figure class="p-authorBox__avatar">
		<?php echo get_avatar( $author_id, 100, '', $author_name ); ?>
	</figure>
	<div class="p-authorBox__body">
		<?php if ( ! is_author() ) : ?>
			<span class="p-authorBox__name"><?php echo esc_html( $author_name ); ?></span>
		<?php endif; ?>
		<?php do_action( 'arkhe_after_author_name', $author_id ); // 役職表示用 ?>
		<?php if ( $description ) : ?>
			<p class="p-authorBox__description u-color-thin">
				<?php echo wp_kses_post( nl2br( $description ) ); ?>
			</p>
		<?php endif; ?>

		<div class="p-authorBox__footer">
			<div class="p-authorBox__links">
				<?php if ( $the_user_link_url ) : ?>
					<div class="p-authorBox__weblink">
						<i class="arkhe-icon-link" role="img" aria-hidden="true"></i> : 
						<a href="<?php echo esc_url( $the_user_link_url ); ?>" target="_blank" rel="noopener" class=""><?php echo esc_html( $the_user_link_url ); ?></a>
					</div>
				<?php endif; ?>
				<?php do_action( 'arkhe_author_links', $author_id ); // アイコンリスト表示用 ?>
			</div>
			<?php if ( ! is_author() ) : ?>
				<div class="p-authorBox__archivelink">
					<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" target="_blank" rel="noopener" class=""><?php esc_html_e( 'To article list', 'arkhe' ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
