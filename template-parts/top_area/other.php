<?php
/**
 * トップエリア（その他のページ用）
 *   この構造を参考にご利用ください。
 */
$the_id  = get_queried_object_id();
$excerpt = 'excerpt...';

// 背景の画像
$bgimg_full   = '';
$bgimg_medium = '';
$bgimg_id     = 0;
if ( $bgimg_id ) {
	$bgimg_full   = wp_get_attachment_image_url( $bgimg_id, 'full' ) ?: '';
	$bgimg_medium = wp_get_attachment_image_url( $bgimg_id, 'medium' ) ?: '';
}

// 追加クラス（画像がなければフィルターもなし）
$add_area_class = $bgimg_full ? '-filter-' . Arkhe::get_setting( 'title_bg_filter' ) : '-filter-none -noimg';
?>
<div id="top_title_area" class="l-content__top p-topArea c-filterLayer <?php echo esc_attr( $add_area_class ); ?>">
	<?php if ( $bgimg_full ) : ?>
		<div class="p-topArea__img c-filterLayer__img lazyload" 
			data-bg="<?php echo esc_attr( $bgimg_full ); ?>"
			style="background-image:url(<?php echo esc_attr( $bgimg_medium ); ?>)"
		></div>
	<?php endif; ?>
	<div class="p-topArea__body l-container">
		<div class="p-topArea__title c-pageTitle">
			<?php
				echo '<h1 class="c-pageTitle__main">タイトル</h1>';
			?>
		</div>
		<?php if ( '' !== $excerpt ) : ?>
			<div class="p-topArea__excerpt u-mt-10">
				<?php echo wp_kses_post( $excerpt ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
