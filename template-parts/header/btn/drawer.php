<?php
/**
 * ハンバーガーメニューボタンの出力テンプレート
 *   $args['label'] : ボタン下のラベル
 */
$label = isset( $args['label'] ) ? $args['label'] : '';
?>
<div class="l-header__drawerBtn">
	<button class="c-iconBtn -menuBtn u-flex--c" data-onclick="toggleMenu" aria-label="<?php esc_attr_e( 'Menu button', 'arkhe' ); ?>">
		<div class="c-iconBtn__icon">
			<?php Arkhe::the_svg( 'menu', array( 'class' => '__open' ) ); ?>
			<?php Arkhe::the_svg( 'close', array( 'class' => '__close' ) ); ?>
		</div>
		<?php if ( $label ) : ?>
			<span class='c-iconBtn__label'><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>
	</button>
</div>
