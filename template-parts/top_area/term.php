<?php
/**
 * トップエリア（タームアーカイブ用）
 */
$term_obj         = get_queried_object();
$term_id          = $term_obj->term_id;
$term_description = apply_filters( 'arkhe_term_description', $term_obj->description, $term_id );
$show_description = apply_filters( 'arkhe_show_term_description', ! empty( $term_description ), $term_id );
$bgimg_id         = apply_filters( 'arkhe_ttlbg_img_id', 0, $term_id );
$lazy_type        = apply_filters( 'arkhe_use_lazy_top_area', false ) ? Arkhe::get_lazy_type() : '';

// 追加クラス（画像がなければフィルターもなし）
$add_area_class = $bgimg_id ? '-filter-' . Arkhe::get_setting( 'title_bg_filter' ) : '-filter-none -noimg';
?>
<div id="top_title_area" class="l-content__top p-topArea c-filterLayer <?php echo esc_attr( $add_area_class ); ?>">
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
	<?php
		if ( $bgimg_id ) :
			Arkhe::get_image( $bgimg_id, array(
				'class'       => 'p-topArea__img c-filterLayer__img u-obf-cover',
				'alt'         => '',
				'loading'     => $lazy_type,
				'aria-hidden' => 'true',
				'decoding'    => 'async',
				'echo'        => true,
			));
		endif;
	?>
</div>
