<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * ヘッダーロゴの出力テンプレート
 *   $parts_args['label'] : ボタンしたのラベル
 *   $parts_args['show_pc'] : PCでもボタンを表示するかどうか
 */
$show_phrase    = isset( $parts_args['show_phrase'] ) ? $parts_args['show_phrase'] : false;
$show_phrase_sp = isset( $parts_args['show_phrase_sp'] ) ? $parts_args['show_phrase_sp'] : false;
$logo_size_pc   = isset( $parts_args['logo_size_pc'] ) ? $parts_args['logo_size_pc'] : '';
$logo_size_sp   = isset( $parts_args['logo_size_sp'] ) ? $parts_args['logo_size_sp'] : '';

// 追加スタイル
$style = '';

// ロゴサイズ
if ( $logo_size_pc ) $style .= '--logo_size_pc:' . $logo_size_pc . 'px;';
if ( $logo_size_sp ) $style .= '--logo_size_sp:' . $logo_size_sp . 'px;';
?>
<div class="l-header__center"<?php if ( $style ) echo ' style="' . esc_attr( $style ) . '"'; ?>>
	<?php if ( is_front_page() ) : ?>
			<h1 class="l-header__logo">
				<?php ARKHE_THEME::get_parts( 'header/logo_img' ); ?>
			</h1>
		<?php else : ?>
			<div class="l-header__logo">
				<?php ARKHE_THEME::get_parts( 'header/logo_img' ); ?>
			</div>
		<?php endif; ?>
	<?php if ( $show_phrase ) : ?>
		<div class="c-catchphrase u-color-thin<?php if ( ! $show_phrase_sp ) echo ' u-only-pc'; ?>">
			<?php echo esc_html( get_option( 'blogdescription' ) ); ?>
		</div>
	<?php endif; ?>
</div>
