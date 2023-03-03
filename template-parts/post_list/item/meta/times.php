<?php
/**
 * 投稿リストの日付
 * memo: 表示するデータだけ渡ってくる
 */
$show_date     = isset( $args['show_date'] ) ? $args['show_date'] : false;
$show_modified = isset( $args['show_modified'] ) ? $args['show_modified'] : false;

// タイムスタンプで投稿日と更新日を取得
$the_id        = get_the_ID();
$date_time     = get_post_datetime( $the_id, 'date' );
$modified_time = get_post_datetime( $the_id, 'modified' );

// 両方表示する設定の場合、更新日は公開日より遅い場合だけ表示
if ( $show_date && $show_modified && false !== $date_time && false !== $modified_time ) {
	$show_modified = ( $date_time->format( 'Ymd' ) < $modified_time->format( 'Ymd' ) ) ? $show_modified : false;
}
?>
<div class="p-postList__times c-postTimes u-color-thin u-flex--aic">
	<?php
		if ( $show_date )  ark_the__postdate( $date_time, 'posted' );
		if ( $show_modified ) ark_the__postdate( $modified_time, 'modified' );
	?>
</div>
