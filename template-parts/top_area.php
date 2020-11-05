<?php
/**
 * コンテンツヘッダー用
 * ::is_show_ttltop()が true の時のみ呼び出される。
 * （テーマの機能としては固定ページでしか使われない）
 */

// ページのID
$the_id = get_queried_object_id();  // get_the_ID() は is_home() でアウト。

// 背景の画像
$bgimg_full   = '';
$bgimg_medium = '';

$bgimg_id = apply_filters( 'arkhe_ttlbg_img_id', get_post_thumbnail_id( $the_id ), $the_id );
if ( $bgimg_id ) {
	$bgimg_full   = wp_get_attachment_image_url( $bgimg_id, 'full' ) ?: '';
	$bgimg_medium = wp_get_attachment_image_url( $bgimg_id, 'medium' ) ?: '';
}


// コンテンツヘッダーに追加するクラス。（画像がなければフィルターもなし）
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
		<?php Arkhe::get_part( 'top_area/body', array( 'the_id' => $the_id ) ); ?>
	</div>
</div>
