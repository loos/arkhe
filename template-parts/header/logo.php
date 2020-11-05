<?php
/**
 * ヘッダーロゴの出力テンプレート
 *   $args['label'] : ボタンしたのラベル
 *   $args['show_pc'] : PCでもボタンを表示するかどうか
 */
$show_phrase    = isset( $args['show_phrase'] ) ? $args['show_phrase'] : false;
$show_phrase_sp = isset( $args['show_phrase_sp'] ) ? $args['show_phrase_sp'] : false;
$logo_size_pc   = isset( $args['logo_size_pc'] ) ? $args['logo_size_pc'] : '';
$logo_size_sp   = isset( $args['logo_size_sp'] ) ? $args['logo_size_sp'] : '';

// 追加スタイル
$style = '';

// ロゴサイズ
if ( $logo_size_pc ) $style .= '--ark-logo_size_pc:' . $logo_size_pc . 'px;';
if ( $logo_size_sp ) $style .= '--ark-logo_size_sp:' . $logo_size_sp . 'px;';
?>
<div class="l-header__center"<?php if ( $style ) echo ' style="' . esc_attr( $style ) . '"'; ?>>
	<?php if ( is_front_page() ) : ?>
			<h1 class="l-header__logo">
				<?php Arkhe::get_part( 'header/logo_img' ); ?>
			</h1>
		<?php else : ?>
			<div class="l-header__logo">
				<?php Arkhe::get_part( 'header/logo_img' ); ?>
			</div>
		<?php endif; ?>
	<?php if ( $show_phrase ) : ?>
		<div class="c-catchphrase u-color-thin<?php if ( ! $show_phrase_sp ) echo ' u-only-pc'; ?>">
			<?php echo esc_html( get_option( 'blogdescription' ) ); ?>
		</div>
	<?php endif; ?>
</div>
