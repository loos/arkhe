<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * ハンバーガーメニューの出力テンプレート
 *   $parts_args['label'] : ボタンしたのラベル
 *   $parts_args['show_pc'] : PCでもボタンを表示するかどうか
 */
$label   = isset( $parts_args['label'] ) ? $parts_args['label'] : '';
$show_pc = isset( $parts_args['show_pc'] ) ? $parts_args['show_pc'] : false;

?>
<div class="l-header__menuBtn<?php if ( ! $show_pc ) echo ' u-only-sp'; ?>">
	<div class="c-iconBtn -menuBtn" data-onclick="toggleMenu" role="button" aria-label="メニューボタン">
		<div class="c-iconBtn__icon">
			<i class='__icon -open arkhe-icon-menu'></i>
			<i class="__icon -close arkhe-icon-close"></i>
		</div>
		<?php if ( $label ) : ?>
			<span class='c-iconBtn__label'><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>
	</div>
</div>
