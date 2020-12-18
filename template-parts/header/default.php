<?php
/**
 * デフォルトヘッダー用テンプレート
 */
$move_gnav_under = Arkhe::get_setting( 'move_gnav_under' );
$logo_pos        = $move_gnav_under ? 'center' : 'left';
?>
<header id="header" class="l-header" <?php \Arkhe::header_attr( array( 'logo_pos' => $logo_pos ) ); ?>>
	<?php if ( has_filter( 'arkhe_header_bar_content' ) ) : ?>
		<div class="l-header__bar">
			<div class="l-header__barInner l-container">
				<?php do_action( 'arkhe_header_bar_content' ); ?>
			</div>
		</div>
	<?php endif; ?>
	<div class="l-header__body l-container">
		<?php \Arkhe::get_part( 'header/drawer_btn' ); ?>
		<div class="l-header__left">
			<?php do_action( 'arkhe_header_left_content' ); ?>
		</div>
		<div class="l-header__center">
			<?php \Arkhe::get_part( 'header/logo' ); ?>
		</div>
		<div class="l-header__right">
			<?php
				if ( ! $move_gnav_under ) :
					\Arkhe::get_part( 'header/gnav' );
				endif;
				do_action( 'arkhe_header_right_content' );
			?>
		</div>
		<?php \Arkhe::get_part( 'header/search_btn' ); ?>
		<?php \Arkhe::get_part( 'header/drawer_menu' ); ?>
	</div>
</header>
<?php if ( $move_gnav_under ) : ?>
	<div class="l-headerUnder" <?php if ( \Arkhe::get_setting( 'fix_gnav' ) )  echo ' data-fix="1"'; ?>>
		<div class="l-headerUnder__inner l-container">
			<?php \Arkhe::get_part( 'header/gnav' ); ?>
		</div>
	</div>
<?php endif; ?>
