<?php
/**
 * ロゴ（画像なし）のテンプレート
 */
?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="c-headLogo -txt" rel="home">
	<?php echo esc_html( get_option( 'blogname' ) ); ?>
</a>
