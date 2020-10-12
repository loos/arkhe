<?php
namespace Arkhe_Theme\Utility;

trait Licence {

	/**
	 * ライセンスステータスを取得( キャッシュがあれば優先 )
	 *
	 * @return json
	 */
	public static function get_licence_data( $licence_key = '' ) {

		$cache_key = 'arkhe_licence_data';

		// キャッシュが残っていればそちらを返す
		$data = get_transient( $cache_key );
		if ( $data ) return $data;

		// ライセンスチェック
		$data = self::check_licence( $licence_key );

		// キャッシュ保存して return
		set_transient( $cache_key, $data, DAY_IN_SECONDS ); // キャッシュ期間 : １日
		return $data;
	}


	/**
	 * ライセンスチェック
	 */
	public static function check_licence( $licence_key = '' ) {

		$send_data = array(
			'type'        => 'get_status',
			'licence_key' => $licence_key,
		);
		// $headers = ['Content-Type: application/json' ];

		// ライセンス用DBに接続
		$response = wp_remote_post(
			\Arkhe::$licence_check_url,
			array(
				'method'      => 'POST',
				'timeout'     => 15,
				'redirection' => 5,
				'sslverify'   => false,
				'body'        => $send_data,
				// 'httpversion' => '1.0',
				// 'blocking'    => true,
				// 'data_format' => 'body',
				// 'headers'     => array(),
			)
		);

		if ( is_wp_error( $response ) ) {
			return array(
				'status'  => 500,
				'error'   => 1,
				'message' => $response->get_error_message(),
			);
		}

		// レスポンスを取得（json なので配列にデコード）
		$get_data = json_decode( $response['body'], true );

		// 配列でない場合や、statusが取得できない時は何かデータがおかしい
		if ( ! is_array( $get_data ) || ! isset( $get_data['status'] ) ) {
			return array(
				'status'  => 500,
				'error'   => 1,
				'message' => 'The data format is incorrect.',
			);
		}

		// 正常なデータ
		return $get_data;
	}

}
