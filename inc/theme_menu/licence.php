<?php

$licence_key    = \Arkhe::$licence_key;
$licence_status = \Arkhe::$licence_status;

// 1分以内に認証を行った回数
$check_count = get_transient( 'arkhe_licence_check_count' ) ?: 0;

// nonceキーチェック
$nonce_verified = false;
if ( isset( $_POST['arkhe_licence_nonce'] ) && isset( $_POST['arkhe_licence_key'] ) ) {

	$nonce       = sanitize_text_field( wp_unslash( $_POST['arkhe_licence_nonce'] ) );
	$licence_key = sanitize_text_field( wp_unslash( $_POST['arkhe_licence_key'] ) );

	if ( ! wp_verify_nonce( $nonce, 'arkhe_licence_nonce' ) ) exit( 'Nonce could not be verified.' );

	set_transient( 'arkhe_licence_check_count', ++$check_count, 60 );

	update_option( \Arkhe::DB_NAMES['licence_key'], $licence_key );

	// ライセンスチェック
	$licence_status = \Arkhe::check_licence( $licence_key );
	set_transient( 'arkhe_licence_status', $licence_status, DAY_IN_SECONDS );

}

// ライセンスステータスを配列に
$licence_status = json_decode( $licence_status, true );

// ライセンスチェック の結果
$message      = '';
$message_type = 'normal';
if ( (int) $check_count > 5 ) {
	$message      = __( 'There are too many authentication requests. Please wait a while and try again.', 'arkhe' );
	$message_type = 'warning';
} elseif ( $licence_status ) {

	if ( $licence_status['error'] ) {

		$message_type = 'error';
		$message      = $licence_status['message'];

	} elseif ( ! $licence_status['valid'] ) {

		$message_type = 'error';
		$email        = $licence_status['message'];
		$message      = __( 'This license is currently suspended.', 'arkhe' );

		// translators: %s is email;
		$message .= sprintf( __( 'The owner is %s .', 'arkhe' ), $email );

	} elseif ( $licence_status['valid'] ) {

		$message_type = 'ok';
		$email        = $licence_status['message'];
		$message      = __( 'Your license key is valid.', 'arkhe' );

		// translators: %s is email;
		$message .= sprintf( __( 'The owner is %s .', 'arkhe' ), $email );

	}
}


?>
<h3><?php esc_html_e( 'License key', 'arkhe' ); ?></h3>
<p><?php esc_html_e( 'With the purchase of the "Arkhe PRO License", you will be able to update all Arche-specific plug-ins to the latest version at any time.', 'arkhe' ); ?></p>
<form method="POST" action="">
	<input type="text" name="arkhe_licence_key" value="<?php echo esc_attr( $licence_key ); ?>" size="40">
	<?php
		wp_nonce_field( 'arkhe_licence_nonce', 'arkhe_licence_nonce' );

		if ( 'warning' !== $message_type ) {
		echo '<button type="submit" class="button button-primary">' . esc_html__( 'Check licence', 'arkhe' ) . '</button>';
		}

		if ( $message ) {
		echo '<div class="arkhe-notice -' . esc_attr( $message_type ) . '">' . esc_html( $message ) . '</div>';
		}
	?>
</form>
