<?php
/**
 * トップエリア（投稿・固定ページ用）
 */
$the_id    = get_queried_object_id();  // get_the_ID() は is_home() でアウト。
$subtitle  = apply_filters( 'arkhe_page_subtitle', '', $the_id, 'top' );
$excerpt   = apply_filters( 'arkhe_top_area_excerpt', '', $the_id );
$bgimg_id  = apply_filters( 'arkhe_ttlbg_img_id', get_post_thumbnail_id( $the_id ), $the_id );
$lazy_type = apply_filters( 'arkhe_use_lazy_top_area', false ) ? Arkhe::get_lazy_type() : '';

// 追加クラス（画像がなければフィルターもなし）
$add_area_class = $bgimg_id ? '-filter-' . Arkhe::get_setting( 'title_bg_filter' ) : '-filter-none -noimg';
?>
<div id="top_title_area" class="l-content__top p-topArea c-filterLayer <?php echo esc_attr( $add_area_class ); ?>">
	<div class="p-topArea__body l-container">
		<div class="p-topArea__title c-pageTitle">
			<?php
				// the_title() に倣ってエスケープ関数はなし
				echo '<h1 class="c-pageTitle__main">' . get_the_title( $the_id ) . '</h1>'; // phpcs:ignore

				if ( '' !== $subtitle ) :
					echo '<div class="c-pageTitle__sub u-mt-5">' . wp_kses( $subtitle, Arkhe::$allowed_text_html ) . '</div>';
				endif;
			?>
		</div>
		<?php if ( '' !== $excerpt ) : ?>
			<div class="p-topArea__excerpt u-mt-10">
				<?php echo wp_kses( $excerpt, Arkhe::$allowed_text_html ); ?>
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
