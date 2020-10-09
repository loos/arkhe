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
	$message      = __( '認証リクエストの回数が多すぎます。しばらく時間を空けてから再試行してください。', 'arkhe' );
	$message_type = 'warning';
} elseif ( $licence_status ) {

	if ( $licence_status['error'] ) {

		$message_type = 'error';
		$message      = $licence_status['message'];

	} elseif ( ! $licence_status['valid'] ) {

		$message_type = 'error';
		$email        = $licence_status['message'];
		$message      = __( 'このライセンスは現在停止中です。', 'arkhe' );

		// translators: %s is email;
		$message .= sprintf( __( '所有者は %s です。', 'arkhe' ), $email );

	} elseif ( $licence_status['valid'] ) {

		$message_type = 'ok';
		$email        = $licence_status['message'];
		$message      = __( '有効なライセンスキーを確認しました。', 'arkhe' );

		// translators: %s is email;
		$message .= sprintf( __( '所有者は %s です。', 'arkhe' ), $email );

	}
}


?>
<h3>Arkhe Pro ライセンスの認証</h3>
<p>
	Arkhe Pro ライセンスを購入すると、全てのArkhe専用プラグインをいつでも最新版へアップデートできるようになります。
</p>
<form method="POST" action="">
	<input type="text" name="arkhe_licence_key" value="<?php echo esc_attr( $licence_key ); ?>" size="40">
	<?php
		wp_nonce_field( 'arkhe_licence_nonce', 'arkhe_licence_nonce' );

		if ( 'warning' !== $message_type ) {
		echo '<button type="submit" class="button button-primary">' . esc_html__( 'ライセンス確認', 'arkhe' ) . '</button>';
		}

		if ( $message ) {
		echo '<div class="arkhe-notice -' . esc_attr( $message_type ) . '">' . esc_html( $message ) . '</div>';
		}
	?>
</form>
