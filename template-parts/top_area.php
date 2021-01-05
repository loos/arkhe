<?php
/**
 * トップエリア用テンプレートファイル
 *   is_show_ttltop()が true の時のみ呼び出される。
 *   （テーマ本体の機能では固定ページでしか使われない）
 */

if ( is_singular() || is_home() ) {
	Arkhe::get_part( 'top_area/singular' );
} elseif ( is_category() || is_tag() || is_tax() ) {
	Arkhe::get_part( 'top_area/term' );
} else {
	Arkhe::get_part( 'top_area/other' );
}
