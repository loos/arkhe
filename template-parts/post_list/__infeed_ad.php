<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * @param int $variable : get_parts()で渡される変数。ここでは投稿ループのカウント数を受け取る想定。
 */
$infeed = ''; // 設定を受け取る？

if ( ! empty( $infeed ) ) {

	$loop_ct = $variable ?: 0;

	$infeed_interval = (int) ARKHE_THEME::get_setting( 'infeed_interval' );  // インフィード広告の間隔
	if ( $loop_ct !== 0 && ( $loop_ct % $infeed_interval === 0 ) ) {
		echo '<li class="p-postList__item c-infeedAd">' . $infeed . '</li>';
	}
}
