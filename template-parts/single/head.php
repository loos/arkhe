<?php
/**
 * 投稿ページのタイトル部分
 */
$the_id = get_the_ID();
?>
<header class="p-entry__head">
	<?php
		// タイトル
		if ( ! Arkhe::is_show_ttltop() ) :
			Arkhe::get_part( 'single/head/title' );
		endif;

		// メタ情報
		Arkhe::get_part( 'single/head/meta' );

		// アイキャッチ画像
		$show_thumb = apply_filters( 'arkhe_show_entry_thumb', Arkhe::get_setting( 'show_entry_thumb' ), $the_id );
		if ( $show_thumb && has_post_thumbnail( $the_id ) ) :
			Arkhe::get_part( 'single/head/thumbnail' );
		endif;
	?>
</header>
