<?php
/**
 * トップエリア（タームアーカイブ用）
 */
$term_obj         = get_queried_object();
$term_id          = $term_obj->term_id;
$term_description = apply_filters( 'arkhe_term_description', $term_obj->description, $term_id );
$show_description = apply_filters( 'arkhe_show_term_description', ! empty( $term_description ), $term_id );

// 背景の画像
$bgimg_id     = apply_filters( 'arkhe_ttlbg_img_id', 0, $term_id );
$bgimg_full   = '';
$bgimg_medium = '';
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
				echo '<h1 class="c-pageTitle__main">' . single_term_title( '', false ) . '</h1>'; // phpcs:ignore
			?>
		</div>
		<?php if ( $show_description ) : ?>
			<div class="p-topArea__excerpt u-mt-10">
				<?php echo wp_kses( $term_description, Arkhe::$allowed_text_html ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
