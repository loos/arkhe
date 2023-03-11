<?php

$licence_key  = \Arkhe::$licence_key;
$licence_data = \Arkhe::$licence_data;

// 1分以内に認証を行った回数
$check_count = get_transient( 'arkhe_licence_check_count' ) ?: 0;

// nonceキーチェック
$nonce_verified = false;

if ( isset( $_POST['_ark_nonce'] ) ) {
	$nonce = \Arkhe::get_cleaned_data( $_POST['_ark_nonce'] ); // phpcs:ignore WordPress.Security
	if ( ! wp_verify_nonce( $nonce, 'arkhe_licence_check' ) ) exit( 'Nonce error.' );

	$submit_type = \Arkhe::get_cleaned_data( filter_input( INPUT_POST, 'submit_type' ) );
	$licence_key = \Arkhe::get_cleaned_data( filter_input( INPUT_POST, 'arkhe_licence_key' ) );

	if ( 'deauthorize' === $submit_type ) {

		update_option( \Arkhe::DB_NAMES['licence_key'], '' );
		delete_transient( 'arkhe_licence_data' ); // キャッシュも削除
		$licence_data = array();
		$licence_key  = '';

	} elseif ( 'license_check' === $submit_type && $licence_key ) {

		set_transient( 'arkhe_licence_check_count', ++$check_count, 60 );

		// ライセンスキーを保存
		update_option( \Arkhe::DB_NAMES['licence_key'], $licence_key );

		// キャッシュは削除してからライセンスチェック
		delete_transient( 'arkhe_licence_data' );
		$licence_data = \Arkhe::get_licence_data( $licence_key );
	}
}

// ライセンスデータ
$is_error   = isset( $licence_data['error'] ) ? (bool) $licence_data['error'] : false;
$the_status = isset( $licence_data['status'] ) ? (int) $licence_data['status'] : 0;
$the_owner  = isset( $licence_data['owner'] ) ? $licence_data['owner'] : '';
$the_email  = isset( $licence_data['email'] ) ? $licence_data['email'] : '';


// ライセンスチェック の結果
$result      = '';
$result_type = 'normal';
if ( (int) $check_count > 5 ) {
	// 試行回数多すぎる時

	$result_type = 'warning';
	$result      = __( 'There are too many authentication requests. Please wait a while and try again.', 'arkhe' );


} elseif ( $licence_data ) {


	if ( $is_error ) {
		// エラーが帰ってきた場合

		$result_type = 'error';
		$result      = $licence_data['message'];

	} elseif ( 0 === $the_status ) {
		// エラーではないがライセンスが停止中だった時

		$result_type = 'error';
		$result      = __( 'This license key is currently disabled.', 'arkhe' );

	} elseif ( 1 === $the_status ) {
		// 個人ライセンスが確認できた時

		$result_type = 'ok';
		$result      = __( 'Your license key is valid.', 'arkhe' );
		$result     .= sprintf(
			// translators: %s is email;
			__( 'This is "%1$s" and is owned by %2$s.', 'arkhe' ),
			__( 'Personal License', 'arkhe' ),
			$the_email
		);


	} elseif ( 2 === $the_status ) {
		// 制作ライセンスが確認できた時

		$result_type = 'ok';
		$result      = __( 'Your license key is valid.', 'arkhe' );
		$result     .= sprintf(
			// translators: %s is owner;
			__( 'This is "%1$s" and is owned by %2$s.', 'arkhe' ),
			__( 'Creator License', 'arkhe' ),
			$the_owner ?: $the_email
		);

	}
}

$has_licence = 1 === $the_status || 2 === $the_status;

?>
<h3><?php esc_html_e( 'License key', 'arkhe' ); ?></h3>
<p>
	<?php
		// $licence_link = \Arkhe::$is_ja ? 'https://arkhe-theme.com/ja/product/arkhe-pro-pack/' : '';
		$licence_link = 'https://arkhe-theme.com/ja/product/arkhe-pro-pack/';

		echo sprintf(
			// translators: %s is link;
			esc_html__( 'Purchasing "%s" will allow you to update all Arkhe plugins to the latest version.', 'arkhe' ),
			'<a href="' . esc_url( $licence_link ) . '">' . esc_html__( 'Arkhe License', 'arkhe' ) . '</a>'
		);
	?>
</p>
<form method="POST" action="">
	<?php wp_nonce_field( 'arkhe_licence_check', '_ark_nonce' ); ?>
	<?php if ( ! $has_licence ) : ?>
		<input type="text" name="arkhe_licence_key" value="<?php echo esc_attr( $licence_key ); ?>" size="40">
		<?php if ( 'warning' !== $result_type ) : ?>
			<button type="submit" name="submit_type" value="license_check" class="button button-primary">
				<?php esc_html_e( 'Check licence', 'arkhe' ); ?>
			</button>
		<?php endif; ?>
	<?php else : ?>
		<span style="line-height: 32px;padding: 0 8px;"><?php echo esc_attr( substr( $licence_key, 0, 4 ) ); ?>************</span>
		<button type="submit" name="submit_type" value="deauthorize" class="button button-secondary">
			<?php esc_html_e( 'Deauthorize', 'arkhe' ); ?>
		</button>
	<?php endif; ?>
	<?php if ( $result ) : ?>
		<div class="arkhe-notice -<?php echo esc_attr( $result_type ); ?>"><?php echo esc_html( $result ); ?></div>
	<?php endif; ?>
</form>
