<?php
/**
 * デフォルトヘッダー用テンプレート
 */
$setting            = Arkhe::get_setting();
$show_drower_pc     = $setting['show_drower_pc'];
$show_search_btn_pc = $setting['show_search_btn_pc'];
$show_search_btn_sp = $setting['show_search_btn_sp'];
$move_gnav_under    = $setting['move_gnav_under'];
$logo_pos           = $move_gnav_under ? 'center' : '';
?>
<header id="header" class="l-header" <?php \Arkhe::header_attr( array( 'logo_pos' => $logo_pos ) ); ?>>
	<div class="l-header__body l-container">
		<?php \Arkhe::get_parts( 'header/menu_btn', array( 'show_pc' => $show_drower_pc ) ); ?>
		<div class="l-header__left u-only-pc"></div>
		<?php \Arkhe::get_parts( 'header/logo' ); ?>
		<!-- <div class="l-header__main"></div> -->
		<div class="l-header__right">
			<?php
				if ( ! $move_gnav_under ) :
				\Arkhe::get_parts( 'header/gnav' );
				endif;

				\Arkhe::get_parts(
					'header/custom_btn',
					array(
						'show_pc' => $show_search_btn_pc,
						'show_sp' => $show_search_btn_sp,
					)
				);
			?>
		</div>
		<?php \Arkhe::get_parts( 'header/drawer_menu' ); ?>
	</div>
</header>
<?php if ( $move_gnav_under ) : ?>
	<div class="l-headerUnder" <?php if ( \Arkhe::get_setting( 'fix_gnav' ) )  echo ' data-fix="1"'; ?>>
		<div class="l-headerUnder__inner l-container">
			<?php \Arkhe::get_parts( 'header/gnav' ); ?>
		</div>
	</div>
<?php endif; ?>
