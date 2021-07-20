<?php
/**
 * 投稿リストの日付
 * $date || $modified のどちらか表示する時だけ渡ってくる
 */
$date     = isset( $args['date'] ) ? $args['date'] : null;
$modified = isset( $args['modified'] ) ? $args['modified'] : null;

// まだ文字列の場合はDateTime化 ( is_stringチェックは後方互換用 )
if ( is_string( $date ) ) $date         = new DateTime( $date );
if ( is_string( $modified ) ) $modified = new DateTime( $modified );

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
