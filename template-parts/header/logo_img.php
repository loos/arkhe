<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * ヘッダーロゴ画像の出力テンプレート
 */
$logo       = apply_filters( 'arkhe_head_logo', ARKHE_THEME::get_setting( 'head_logo' ) );
$site_title = get_option( 'blogname' );

// ロゴ画像の設定があるかどうか
$logo_type = $logo ? 'img' : 'txt';
?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="c-headLogo" data-logo-type="<?php echo esc_attr( $logo_type ); ?>" rel="home">
<?php
	if ( 'txt' === $logo_type ) :
		echo esc_html( $site_title );
	else :
		if ( ARKHE_THEME::is_header_overlay() ) :
			// ヘッダーオーバーレイ有効時
			$logo_ovrly = apply_filters( 'arkhe_head_logo_overlay', ARKHE_THEME::get_setting( 'head_logo_overlay' ) );
			$logo_ovrly = $logo_ovrly ?: $logo;

			echo '<img src="' . esc_url( $logo_ovrly ) . '" alt="' . esc_attr( $site_title ) . '" class="c-headLogo__img -top">' .
				'<img src="' . esc_url( $logo ) . '" alt="" class="c-headLogo__img -common" role="presentation">';
		else :
			echo '<img src="' . esc_url( $logo ) . '" alt="' . esc_attr( $site_title ) . '" class="c-headLogo__img">';
		endif;
	endif;
?>
</a>
