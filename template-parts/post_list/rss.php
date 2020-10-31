<?php
/**
 * 投稿一覧リストの出力テンプレート（サブループ用）
 *   $args['list_args'] : リストの表示に関する設定値（メインループでは 'type' しか渡されてこない）
 */
$rss_items = isset( $args['rss_items'] ) ? $args['rss_items'] : array();
$list_args = isset( $args['list_args'] ) ? $args['list_args'] : array();

if ( empty( $rss_items ) ) return;

// リストタイプ
$list_type = isset( $list_args['list_type'] ) ? $list_args['list_type'] : ARKHE_LIST_TYPE;

// リストスタイルによって読み込むファイル名を振り分ける
$file_name = ( 'simple' === $list_type ) ? 'simple' : 'normal';

// ループのカウント用変数
$loop_count = 0;

// 抜粋分の文字数の指定があれば
// if ( isset( $list_args['excerpt_length'] ) ) {
// 	\Arkhe::$excerpt_length = $list_args['excerpt_length'];
// }

$list_count_pc = $list_args['list_count_pc'];
$list_count_sp = $list_args['list_count_sp'];

$min        = min( $list_count_pc, $list_count_sp );
$max        = max( $list_count_pc, $list_count_sp );
$list_class = $min === $list_count_pc ? 'u-only-sp' : 'u-only-pc';

?>
<ul class="p-postList -type-<?php echo esc_attr( $list_type ); ?> is-rss">
	<?php
	foreach ( $rss_items as $feed_data ) {
		$loop_count++;

		if ( $max < $loop_count ) {
			break;
		} elseif ( $min < $loop_count ) {
			$list_args['list_class'] = $list_class;
		}

		$list_args['count'] = $loop_count;

		Arkhe::get_parts( 'post_list/style/rss_' . $file_name, array(
			'list_args' => $list_args,
			'feed_data' => $feed_data,
		) );
	}
?>
</ul>
<?php

// データリセット
// wp_reset_postdata();
// \Arkhe::$excerpt_length = ARKHE_EXCERPT_LENGTH;
