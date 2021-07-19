<?php
/**
 * 固定ページヘッド部分 (コンテンツ内)
 *   home.php からも呼ばれることに注意。
 */
$the_id = get_queried_object();
if ( ! $the_id ) return;
?>
<div class="p-page__title c-pageTitle u-flex--aic">
	<?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<h1 class="c-pageTitle__main">' . get_the_title( $the_id ) . '</h1>'; // the_title() に倣ってエスケープ関数はなし

		// サブタイトル
		$subtitle = apply_filters( 'arkhe_page_subtitle', '', $the_id, 'inner' );
		if ( '' !== $subtitle ) :
		echo '<div class="c-pageTitle__sub">' . wp_kses( $subtitle, Arkhe::$allowed_text_html ) . '</div>';
		endif;
	?>
</div>
