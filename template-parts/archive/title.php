<?php
/**
 * アーカイブタイトルを出力する
 *   $args['title'] : アーカイブタイトル
 *   $args['type'] : アーカイブ種別 (フック用)
 */
$the_title = isset( $args['title'] ) ? $args['title'] : '';
?>
<div class="p-archive__title c-pageTitle">
	<h1 class="c-pageTitle__main"><?php echo esc_html( $the_title ); ?></h1>
</div>
