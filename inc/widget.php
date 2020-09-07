<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ウィジェット登録
 */
add_action( 'widgets_init', 'arkhe_hook__widgets_init' );

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
}
