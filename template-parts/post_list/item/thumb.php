<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿リストに表示されるサムネイル画像
 */
$the_id    = isset( $parts_args['post_id'] ) ? $parts_args['post_id'] : 0;
$list_type = isset( $parts_args['list_type'] ) ? $parts_args['list_type'] : POST_LIST_TYPE;

// サムネイル画像取得
$sp_sizes = 'card' === $list_type ? '100vw' : '40vw';
?>
<div class="p-postList__thumb c-postThumb<?php echo ! has_post_thumbnail( $the_id ) ? ' has-nothumb' : ''; ?>">
	<figure class="c-postThumb__figure">
		<?php // @codingStandardsIgnoreStart
			echo ARKHE_THEME::get_thumbnail(
				$the_id,
				array(
					'size'        => 'large',
					'sizes'       => '(min-width: 600px) 400px, ' . $sp_sizes,
					'class'       => 'c-postThumb__img',
				)
			);
		// @codingStandardsIgnoreEnd ?>
	</figure>
</div>
