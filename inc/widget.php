<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ウィジェット登録
 */
add_action( 'widgets_init', 'arkhe_hook__widgets_init' );

if ( ! function_exists( 'arkhe_hook__widgets_init' ) ) :
function arkhe_hook__widgets_init() {

	// 標準の「最新の投稿」ウィジェットを削除して上書き
	unregister_widget( 'wp_widget_recent_posts' );
	register_widget( '\ARKHE_THEME\Widget\Recent_Posts' );

	// ウィジェットエリアを登録
	register_sidebar(
		array(
			'name'          => 'サイドバー',
			'id'            => 'sidebar-1',
			'description'   => 'サイドバーに表示されます。',
			'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="c-widget__title -side">',
			'after_title'   => '</div>',
		)
	);
	register_sidebar(
		array(
			'name'          => 'ドロワーメニュー下部',
			'id'            => 'drawer_bottom',
			'description'   => 'ドロワーメニューの下部に表示されます。',
			'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="c-widget__title -spmenu">',
			'after_title'   => '</div>',
		)
	);
	// register_sidebar(
	// 	array(
	// 		'name'          => '固定ページ上部',
	// 		'id'            => 'page_top',
	// 		'description'   => '固定ページのコンテンツ上部に表示されます。',
	// 		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
	// 		'after_widget'  => '</div>',
	// 		'before_title'  => '<h2 class="c-secTitle -widget"><span>',
	// 		'after_title'   => '</span></h2>',
	// 	)
	// );
	// register_sidebar(
	// 	array(
	// 		'name'          => '固定ページ下部',
	// 		'id'            => 'page_bottom',
	// 		'description'   => '固定ページのコンテンツ下部に表示されます。',
	// 		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
	// 		'after_widget'  => '</div>',
	// 		'before_title'  => '<h2 class="c-secTitle -widget"><span>',
	// 		'after_title'   => '</span></h2>',
	// 	)
	// );
	// register_sidebar(
	// 	array(
	// 		'name'          => '記事上部',
	// 		'id'            => 'single_top',
	// 		'description'   => '投稿ページのコンテンツ上部に表示されます。',
	// 		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
	// 		'after_widget'  => '</div>',
	// 		'before_title'  => '<h2 class="c-secTitle -widget">',
	// 		'after_title'   => '</h2>',
	// 	)
	// );
	// register_sidebar(
	// 	array(
	// 		'name'          => '記事下部',
	// 		'id'            => 'single_bottom',
	// 		'description'   => '投稿ページのコンテンツ下部に表示されます。',
	// 		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
	// 		'after_widget'  => '</div>',
	// 		'before_title'  => '<h2 class="c-secTitle -widget">',
	// 		'after_title'   => '</h2>',
	// 	)
	// );
}
endif;
