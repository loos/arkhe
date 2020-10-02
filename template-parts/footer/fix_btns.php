<?php
/**
 * 画面右下に固定表示するボタン
 *   他にボタン追加するなら p-fixBtnWrap の中に
 */
if ( Arkhe::get_setting( 'show_pagetop' ) ) : ?>
	<div class="p-fixBtnWrap">
		<div id="pagetop" class="c-fixBtn -pagetop" data-onclick="pageTop" role="button">
			<i class="c-fixBtn__icon arkhe-icon-chevron-up" role="presentation"></i>
		</div>
	</div>
<?php
endif;
