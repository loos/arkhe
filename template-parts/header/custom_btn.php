<?php
/**
 * カスタムメニューボタンの出力テンプレート
 *   $args['label'] : ボタンしたのラベル
 *   $args['hide_pc'] : PCでもボタンを表示するかどうか
 */
$label      = isset( $args['label'] ) ? $args['label'] : '';
$href       = isset( $args['href'] ) ? $args['href'] : '';
$icon_class = isset( $args['icon_class'] ) ? $args['icon_class'] : '';
$is_search  = isset( $args['is_search'] ) ? $args['is_search'] : true;
$show_pc    = isset( $args['show_pc'] ) ? $args['show_pc'] : false;
$show_sp    = isset( $args['show_sp'] ) ? $args['show_sp'] : true;

// PCでもSPでも表示しない
if ( ! $show_pc && ! $show_sp) return;

// 表示制御用のクラス
$diplay_class                    = '';
if ( ! $show_pc ) $diplay_class .= ' u-hide-pc';
if ( ! $show_sp ) $diplay_class .= ' u-hide-sp';
?>
<div class="l-header__customBtn<?php if ( $diplay_class ) echo esc_attr( $diplay_class ); ?>">
	<?php if ( $is_search ) : ?>
		<button class="c-iconBtn" data-onclick="toggleSearch" aria-label="<?php esc_attr_e( 'Search button', 'arkhe' ); ?>">
			<span class="c-iconBtn__icon"><i class="__icon arkhe-icon-search"></i></span>
			<span class="c-iconBtn__label"><?php echo esc_html( $label ); ?></span>
		</button>
	<?php else : ?>
		<a href="<?php echo esc_url( $href ); ?>" class="c-iconBtn">
			<span class="c-iconBtn__icon"><i class="<?php echo esc_attr( $icon_class ); ?>"></i></span>
			<span class="c-iconBtn__label"><?php echo esc_html( $label ); ?></span>
		</a>
	<?php endif; ?>
</div>
