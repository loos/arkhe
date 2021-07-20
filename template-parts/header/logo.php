<?php
/**
 * ヘッダーロゴの出力テンプレート
 */
$logo_size_pc    = isset( $args['logo_size_pc'] ) ? $args['logo_size_pc'] : '';
$logo_size_sp    = isset( $args['logo_size_sp'] ) ? $args['logo_size_sp'] : '';
$show_tagline    = isset( $args['show_tagline'] ) ? $args['show_tagline'] : false;
$show_tagline_sp = isset( $args['show_tagline_sp'] ) ? $args['show_tagline_sp'] : false;

// ロゴID
$logo_id = get_theme_mod( 'custom_logo' ) ?: 0;

// 追加スタイル
$style = '';

if ( ! $logo_id ) {
	$logo_type    = 'text';
	$logo_content = esc_html( get_option( 'blogname' ) );
} else {

	if ( $logo_size_pc ) $style .= '--ark-logo_size_pc:' . $logo_size_pc . 'px;';
	if ( $logo_size_sp ) $style .= '--ark-logo_size_sp:' . $logo_size_sp . 'px;';

	$logo_type    = 'image';
	$logo_content = ark_get__head_logo_img( $logo_id );
}

// ロゴ部分の出力
$logo_tag = apply_filters( 'arkhe_logo_tag', is_front_page() ? 'h1' : 'div' );
echo '<' . esc_attr( $logo_tag ) . ' class="l-header__logo has-' . esc_attr( $logo_type ) . '"',
		$style ? ' style="' . esc_attr( $style ) . '"' : '' ,
	'>' .
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'<a href="' . esc_url( home_url( '/' ) ) . '" class="c-headLogo" rel="home">' . $logo_content . '</a>' .
	'</' . esc_attr( $logo_tag ) . '>';


// キャッチフレーズの出力
if ( $show_tagline ) {
	ark_the__tagline( $show_tagline_sp ? 'u-color-thin' : 'u-color-thin u-only-pc' );
}
