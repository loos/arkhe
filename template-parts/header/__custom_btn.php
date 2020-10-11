<?php
/**
 * カスタムメニューボタンの出力テンプレート
 */
$label      = isset( $args['label'] ) ? $args['label'] : '';
$href       = isset( $args['href'] ) ? $args['href'] : '';
$icon_class = isset( $args['icon_class'] ) ? $args['icon_class'] : '';

?>
<a href="<?php echo esc_url( $href ); ?>" class="c-iconBtn">
	<span class="c-iconBtn__icon"><i class="<?php echo esc_attr( $icon_class ); ?>"></i></span>
	<span class="c-iconBtn__label"><?php echo esc_html( $label ); ?></span>
</a>
