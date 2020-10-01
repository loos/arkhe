<?php
/**
 * ハンバーガーメニューの出力テンプレート
 *   $args['label'] : ボタンしたのラベル
 *   $args['show_pc'] : PCでもボタンを表示するかどうか
 */
$label   = isset( $args['label'] ) ? $args['label'] : '';
$show_pc = isset( $args['show_pc'] ) ? $args['show_pc'] : false;

?>
<div class="l-header__menuBtn<?php if ( ! $show_pc ) echo ' u-only-sp'; ?>">
	<button class="c-iconBtn -menuBtn" data-onclick="toggleMenu" aria-label="<?php esc_attr_e( 'Menu button', 'arkhe' ); ?>">
		<div class="c-iconBtn__icon">
			<i class='__icon -open arkhe-icon-menu'></i>
			<i class="__icon -close arkhe-icon-close"></i>
		</div>
		<?php if ( $label ) : ?>
			<span class='c-iconBtn__label'><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>
	</button>
</div>
