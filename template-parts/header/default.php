<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * デフォルトヘッダー用テンプレート
 */
?>
<header id="header" class="l-header" <?php \ARKHE_THEME::header_attr(); ?>>
	<div class="l-header__body l-container">
		<?php \ARKHE_THEME::get_parts( 'header/menu_btn' ); ?>
		<div class="l-header__main">
			<?php \ARKHE_THEME::get_parts( 'header/logo' ); ?>
			<?php \ARKHE_THEME::get_parts( 'header/gnav' ); ?>
		</div>
		<?php \ARKHE_THEME::get_parts( 'header/custom_btn' ); ?>
		<?php \ARKHE_THEME::get_parts( 'header/drawer_menu' ); ?>
	</div>
</header>
