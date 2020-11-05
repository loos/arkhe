<?php
/**
 * ヘッダーロゴ画像の出力テンプレート
 */
$site_title = get_option( 'blogname' );
$logo_id    = get_theme_mod( 'custom_logo' );

// ロゴ画像の設定があるかどうか
$logo_type = $logo_id ? 'img' : 'txt';
?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="c-headLogo -<?php echo esc_attr( $logo_type ); ?>" rel="home">
<?php
	if ( 'txt' === $logo_type ) :
		echo esc_html( $site_title );
	else :
		// カスタムロゴのURLを取得
		$logo_url = apply_filters( 'arkhe_head_logo_url', wp_get_attachment_image_url( $logo_id, 'full' ) );

		if ( Arkhe::is_header_overlay() ) :
			// ヘッダーオーバーレイ有効時

			// オーバーレイロゴのURLを取得
			$ovrly_logo_id  = Arkhe::get_setting( 'head_logo_overlay' ) ?: $logo_id;
			$ovrly_logo_url = apply_filters( 'arkhe_head_logo_overlay_url', wp_get_attachment_image_url( $ovrly_logo_id, 'full' ) );

			echo '<img src="' . esc_url( $ovrly_logo_url ) . '" alt="' . esc_attr( $site_title ) . '" class="c-headLogo__img -top">';
			echo '<img src="' . esc_url( $logo_url ) . '" alt="" class="c-headLogo__img -common" role="presentation">';
		else :
			// 通常時
			echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $site_title ) . '" class="c-headLogo__img">';
		endif;
	endif;
?>
</a>
