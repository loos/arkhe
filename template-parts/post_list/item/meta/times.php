<?php
/**
 * 投稿リストの日付
 * memo: 表示するデータだけ渡ってくる
 */
$date     = isset( $args['date'] ) ? $args['date'] : null;
$modified = isset( $args['modified'] ) ? $args['modified'] : null;

// タイムスタンプ化 null → false
$date     = strtotime( $date );
$modified = strtotime( $modified );

// 両方表示する設定の場合、更新日は公開日より遅い場合だけ表示
if ( $date && $modified ) {
	$modified = ( $date < $modified ) ? $modified : null;
}
?>
<div class="p-postList__times c-postTimes u-color-thin u-flex--aic">
	<?php
		if ( $date )  ark_the__postdate( $date, 'posted' );
		if ( $modified ) ark_the__postdate( $modified, 'modified' );
	?>
</div>
