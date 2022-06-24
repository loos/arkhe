<?php
/**
 * 画面右下に固定表示するボタン
 *   他にボタン追加するなら p-fixBtnWrap の中に
 */
if ( Arkhe::get_setting( 'show_pagetop' ) ) : ?>
	<div class="p-fixBtnWrap">
		<div id="pagetop" class="c-fixBtn -pagetop u-flex--c" data-onclick="pageTop" role="button" aria-label="To top">
			<?php
			Arkhe::the_svg( 'chevron-up', array(
				'class' => 'c-fixBtn__icon',
				'size'  => '20',
			) );
?>
		</div>
	</div>
<?php
endif;
