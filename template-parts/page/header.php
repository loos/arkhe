<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 固定ページヘッド部分 (コンテンツ内)
 * home.php からも呼ばれることに注意。
 */
$the_id    = isset( $args['post_id'] ) ? $args['post_id'] : get_queried_object();
$the_title = get_the_title( $the_id );

if ( ! Arkhe_Theme::is_show_ttltop() ) : ?>
	<h1 class="p-page__title c-pageTitle"><?php the_title(); ?></h1>
	<?php
	// アイキャッチ画像
	if ( Arkhe_Theme::get_setting( 'show_page_thumb' ) ) :
		Arkhe_Theme::get_parts(
			'singular/thumbnail',
			array(
				'post_id'    => $the_id,
				'post_title' => $the_title,
			)
		);
	endif;
endif;
