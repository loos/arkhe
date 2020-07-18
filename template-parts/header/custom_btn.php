<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * カスタムメニューボタンの出力テンプレート
 *   $parts_args['label'] : ボタンしたのラベル
 *   $parts_args['hide_pc'] : PCでもボタンを表示するかどうか
 */
$label      = isset( $parts_args['label'] ) ? $parts_args['label'] : '';
$href       = isset( $parts_args['href'] ) ? $parts_args['href'] : '';
$icon_class = isset( $parts_args['icon_class'] ) ? $parts_args['icon_class'] : '';
$is_search  = isset( $parts_args['is_search'] ) ? $parts_args['is_search'] : true;
$show_pc    = isset( $parts_args['show_pc'] ) ? $parts_args['show_pc'] : false;
$show_sp    = isset( $parts_args['show_sp'] ) ? $parts_args['show_sp'] : true;

// PCでもSPでも表示しない
if ( ! $show_pc && ! $show_sp) return;

// 表示制御用のクラス
$diplay_class                    = '';
if ( ! $show_pc ) $diplay_class .= ' u-hide-pc';
if ( ! $show_sp ) $diplay_class .= ' u-hide-sp';
?>
<div class="l-header__customBtn<?php if ( $diplay_class ) echo $diplay_class; ?>">
	<?php if ( $is_search ) : ?>
		<div class="c-iconBtn" data-onclick="toggleSearch" role="button">
			<span class="c-iconBtn__icon"><i class="__icon arkhe-icon-search"></i></span>
			<span class="c-iconBtn__label"><?php echo esc_html( $label ); ?></span>
		</div>
	<?php else : ?>
		<a href="<?php echo esc_url( $href ); ?>" class="c-iconBtn">
			<span class="c-iconBtn__icon"><i class="<?php echo esc_attr( $icon_class ); ?>"></i></span>
			<span class="c-iconBtn__label"><?php echo esc_html( $label ); ?></span>
		</a>
	<?php endif; ?>
</div>
