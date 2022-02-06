<?php
/**
 * トップエリア（その他のページ用）
 *   memo: テーマからは利用されないファイルです。特殊なページでトップエリアを設置したい時に、このファイルを参考にしてください。
 */
$the_id    = get_queried_object_id();
$lazy_type = apply_filters( 'arkhe_use_lazy_top_area', false ) ? Arkhe::get_lazy_type() : '';

// 背景画像のID
$bgimg_id = 0;

// 追加クラス（画像がなければフィルターもなし）
$add_area_class = $bgimg_id ? '-filter-' . Arkhe::get_setting( 'title_bg_filter' ) : '-filter-none -noimg';
?>
<div id="top_title_area" class="l-content__top p-topArea c-filterLayer <?php echo esc_attr( $add_area_class ); ?>">
	<div class="p-topArea__body l-container">
		<div class="p-topArea__title c-pageTitle">
			<h1 class="c-pageTitle__main">タイトル</h1>
		</div>
		<div class="p-topArea__excerpt u-mt-10">
			the excerpt...
		</div>
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
