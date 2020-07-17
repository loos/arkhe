<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$SETTING = ARKHE_THEME::get_setting();
?>
<div id="fix_bottom_menu">
	<ul class="menu_list">
		<li class="menu-item menu_btn" data-onclick="toggleMenu">
			<i class="arkhe-icon-menu -menu"></i>
			<span>メニュー</span>
		</li>
		<?php
		wp_nav_menu(
			array(
				'container'       => '',
				'fallback_cb'     => '',
				'theme_location'  => 'fix_bottom_menu',
				'items_wrap'      => '%3$s',
				'link_before'     => '',
				'link_after'      => '',
			)
		);
		?>
		<li class="menu-item" data-onclick="toggleSearch">
			<i class="arkhe-icon-search"></i>
			<span>検索</span>
		</li>
		<li class="menu-item" data-onclick="toggleSearch">
			<i class="arkhe-icon-check"></i>
			<span>項目</span>
		</li>
		<li class="menu-item -pagetop" data-onclick="pageTop">
			<i class="arkhe-icon-chevron-up"></i>
			<span>ページトップ</span>
		</li>
	</ul>
</div>
