<?php
/**
 * ヘッダーバー
 */
if ( ! has_filter( 'arkhe_header_bar_content' ) ) return;
?>
<div class="l-header__bar">
	<div class="l-header__barInner l-container">
		<?php do_action( 'arkhe_header_bar_content' ); ?>
	</div>
</div>
