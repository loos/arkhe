<?php
/**
 * for ~1.4
 */
$logo_id    = isset( $args['logo_id'] ) ? $args['logo_id'] : 0;
$site_title = get_option( 'blogname' );

?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="c-headLogo -img" rel="home">
	<?php
		// カスタムロゴのURLを取得
		$logo_url = apply_filters( 'arkhe_head_logo_url', wp_get_attachment_image_url( $logo_id, 'full' ) );

		if ( Arkhe::is_header_overlay() ) :
			// ヘッダーオーバーレイ有効時

			// オーバーレイロゴのURLを取得
			$ovrly_logo_id  = Arkhe::get_setting( 'head_logo_overlay' ) ?: $logo_id;
			$ovrly_logo_url = apply_filters( 'arkhe_head_logo_overlay_url', wp_get_attachment_image_url( $ovrly_logo_id, 'full' ) );

			echo '<img src="' . esc_url( $ovrly_logo_url ) . '" alt="' . esc_attr( $site_title ) . '" class="c-headLogo__img -top">';
			echo '<img src="' . esc_url( $logo_url ) . '" alt="" class="c-headLogo__img -common" aria-hidden="true">';
		else :
			// 通常時
			echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $site_title ) . '" class="c-headLogo__img">';
		endif;
	?>
</a>
