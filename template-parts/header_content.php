<?php
/**
 * ヘッダー用テンプレート
 *   ブロックで生成されている場合はそちらを優先する
 */
$header_id = 0;
if ( defined( 'ARKHE_TMPID_KEY' ) && \Arkhe::get_plugin_data( 'use_temlate_block' ) ) {

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
	wp_reset_postdata();

	if ( $header ) {
		$header_content = $header[0]->post_content;

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo do_blocks( do_shortcode( $header_content ) );
	}
} else {
	// 通常時
	Arkhe::get_part( 'header/default' );
}
