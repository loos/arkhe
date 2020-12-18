<?php
/**
 * ヘッダー用テンプレート
 *   専用プラグインを使ってヘッダーブロックが生成されている場合はそちらを優先する
 */
$use_header_block = apply_filters( 'arkhe_use_header_block', \Arkhe::get_plugin_data( 'use_temlate_block' ) );

if ( $use_header_block ) {

	// ヘッダーブロックを呼び出し
	echo do_blocks( do_shortcode( Arkhe::get_header_block_content() ) ); // phpcs:ignore

} else {

	// 通常時
	Arkhe::get_part( 'header/default' );

}
