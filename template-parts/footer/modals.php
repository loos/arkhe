<?php
/**
 * フッターの後に配置するモーダルコンテンツ
 */
?>
<?php // 検索モーダル ?>
<div id="search_modal" class="c-modal p-searchModal">
	<div class="c-overlay" data-onclick="toggleSearch"></div>
	<div class="p-searchModal__inner">
		<?php echo get_search_form(); ?>
		<button type="button" class="p-searchModal__close c-modalClose u-flex--aic" data-onclick="toggleSearch">
			<?php
				Arkhe::the_svg( 'close' );
				esc_html_e( 'CLOSE', 'arkhe' );
			?>
		</button>
	</div>
</div>
<?php // ドロワーメニューの下側に敷いておく ?>
<div class="p-drawerUnderlayer" data-onclick="toggleMenu"></div>
