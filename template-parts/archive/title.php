<?php
/**
 * アーカイブタイトルを出力する
 */
$archive_title = \Arkhe::get_archive_data( 'title' );
?>
<div class="p-archive__title c-pageTitle">
	<h1 class="c-pageTitle__main"><?php echo esc_html( $archive_title ); ?></h1>
</div>
