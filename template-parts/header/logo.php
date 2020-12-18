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

// ロゴサイズの設定があれば
if ( $logo_size_pc ) $style .= '--ark-logo_size_pc:' . $logo_size_pc . 'px;';
if ( $logo_size_sp ) $style .= '--ark-logo_size_sp:' . $logo_size_sp . 'px;';

// ロゴ部分のタグ
$logo_tag = is_front_page() ? 'h1' : 'div';
$logo_tag = apply_filters( 'arkhe_logo_tag', $logo_tag );

// ロゴ画像の設定があるかどうか
$logo_id   = get_theme_mod( 'custom_logo' );
$logo_type = $logo_id ? 'image' : 'text';

echo '<' . esc_attr( $logo_tag ) . ' class="l-header__logo has-' . esc_attr( $logo_type ) . '"',
		( $style ) ? ' style="' . esc_attr( $style ) . '"' : '',
	'>';
	Arkhe::get_part( 'header/logo_img', array( 'logo_id' => $logo_id ) );
echo '</' . esc_attr( $logo_tag ) . '>';

if ( $show_phrase ) :
	echo '<div class="c-tagline u-color-thin',
		( ! $show_phrase_sp ) ? ' u-only-pc' : '',
	'">' . esc_html( get_option( 'blogdescription' ) ) . '</div>';
endif;
