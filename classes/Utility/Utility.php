<?php
namespace Arkhe_Theme\Utility;

trait Utility {


	/**
	 * アーカイブページのデータを取得
	 * ['type'] : cayegory | tag | tax | etc...
	 * ['title'] : そのアーカイブページのタイトルとして表示する文字列
	 */
	public static function get_archive_data() {

		if ( ! is_archive() ) return false;

		$data = array(
			'type'  => '',
			'title' => '',
		);

		if ( is_date() ) {
			// 日付アーカイブなら

			$qv_day      = get_query_var( 'day' );
			$qv_monthnum = get_query_var( 'monthnum' );
			$qv_year     = get_query_var( 'year' );

			if ( 0 !== $qv_day ) {
				$ymd_name = $qv_year . '年' . $qv_monthnum . '月' . $qv_day . '日';
			} elseif ( 0 !== $qv_monthnum ) {
				$ymd_name = $qv_year . '年' . $qv_monthnum . '月';
			} else {
				$ymd_name = $qv_year . '年';
			}
			if ( is_post_type_archive() ) {
				// さらに、投稿タイプの日付アーカイブだった場合
				$data['title'] = $ymd_name . '(' . post_type_archive_title( '', false ) . ')';
			}
			$data['title'] = $ymd_name;
			$data['type']  = 'date';

		} elseif ( is_post_type_archive() ) {
			// 投稿タイプのアーカイブページなら

			$data['title'] = post_type_archive_title( '', false );
			$data['type']  = 'pt_archive';

		} elseif ( is_author() ) {
			// 投稿者アーカイブ

			$data['title'] = get_queried_object()->display_name;
			$data['type']  = 'author';

		} elseif ( is_category() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'category';

		} elseif ( is_tag() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tag';

		} elseif ( is_tax() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tax';

		} else {

			$data['title'] = single_term_title( '', false );
			$data['type']  = '';

		}

		return $data;
	}

	/**
	 * ライセンスチェック
	 */
	public static function check_licence( $licence_key = '' ) {

		$data = array(
			'type'        => 'get_status',
			'licence_key' => $licence_key,
		);
		// $headers = ['Content-Type: application/json' ];

		$response = wp_remote_post(
			\Arkhe::$licence_check_url,
			array(
				'method'      => 'POST',
				'timeout'     => 15,
				'redirection' => 5,
				'sslverify'   => false,
				'body'        => $data,
				// 'httpversion' => '1.0',
				// 'blocking'    => true,
				// 'data_format' => 'body',
				// 'headers'     => array(),
			)
		);

		if ( is_wp_error( $response ) ) {
			return wp_json_encode(
				array(
					'valid'   => false,
					'error'   => true,
					'path'    => '',
					'message' => $response->get_error_message(),
				)
			);
		}

		return $response['body']; // json
	}

}
