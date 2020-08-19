<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * ヘッダー用テンプレート
 *   ブロックで生成されている場合はそちらを優先する
 */
$header_id = 0;
if ( defined( 'ARKHE_TMPID_KEY' ) ) {

	$template_id_data = get_option( ARKHE_TMPID_KEY );
	if ( isset( $template_id_data['header'] ) ) {
		$header_id = $template_id_data['header'] ?: 0;
	}
}

if ( apply_filters( 'arkhe_header_id', $header_id ) ) {
	// ブロックで構成する場合
	$header = get_posts(
		array(
			'post_type' => 'arkhe_template',
			'p'         => $header_id,
		)
	);

	if ( $header ) {
		$header_content = $header[0]->post_content;

		// @codingStandardsIgnoreStart
		echo do_blocks( do_shortcode( $header_content ) );
		// @codingStandardsIgnoreEnd
	}
} else {
	// 通常時
	ARKHE_THEME::get_parts( 'header/default' );
}
