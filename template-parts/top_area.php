<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * コンテンツヘッダー用
 * ::is_show_ttltop()が true の時のみ呼び出される。
 * （テーマの機能としては固定ページでしか使われない）
 */

// ページのID
$page_id = get_queried_object_id();  // get_the_ID() は is_home() でアウト。

// 背景の画像
$bgimg_full   = get_the_post_thumbnail_url( $page_id, 'full' );
$bgimg_medium = $bgimg_full ? get_the_post_thumbnail_url( $page_id, 'medium' ) : '';

// コンテンツヘッダーに追加するクラス。（画像がなければフィルターもなし）
$add_area_class = $bgimg_full ? '-filter-' . ARKHE_THEME::get_setting( 'title_bg_filter' ) : '-filter-none -noimg';
?>
<div id="top_title_area" class="l-content__top p-topArea c-filterLayer <?php echo esc_attr( $add_area_class ); ?>">
	<?php if ( $bgimg_full ) : ?>
		<div class="p-topArea__img c-filterLayer__img lazyload" 
			data-bg="<?php echo esc_attr( $bgimg_full ); ?>"
			style="background-image:url(<?php echo esc_attr( $bgimg_medium ); ?>)"
		></div>
	<?php endif; ?>
	<div class="p-topArea__body l-container">
		<?php ARKHE_THEME::get_parts( 'top_area/content', array( 'post_id' => $page_id ) ); ?>
	</div>
</div>
