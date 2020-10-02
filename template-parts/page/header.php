<?php
/**
 * 固定ページヘッド部分 (コンテンツ内)
 * home.php からも呼ばれることに注意。
 */
$the_id    = isset( $args['post_id'] ) ? $args['post_id'] : get_queried_object();
$the_title = get_the_title( $the_id );

if ( ! Arkhe::is_show_ttltop() ) : ?>
	<h1 class="p-page__title c-pageTitle"><?php the_title(); ?></h1>
	<?php
	// アイキャッチ画像
	if ( Arkhe::get_setting( 'show_page_thumb' ) ) :
		Arkhe::get_parts(
			'singular/thumbnail',
			array(
				'post_id'    => $the_id,
				'post_title' => $the_title,
			)
		);
	endif;
endif;
