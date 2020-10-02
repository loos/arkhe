<?php
/**
 * フッターの後にあるコンテンツ
 */

Arkhe::get_parts( 'footer/fix_btns' );
?>
<?php // 検索モーダル ?>
<div id="search_modal" class="c-modal p-searchModal">
	<div class="c-overlay" data-onclick="toggleSearch"></div>
	<div class="p-searchModal__inner">
		<?php echo get_search_form(); ?>
	</div>
</div>
<?php // ドロワーメニューの下側に敷いておく ?>
<div class="p-drawerUnderlayer" data-onclick="toggleMenu"></div>
