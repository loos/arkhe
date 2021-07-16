<?php
namespace Arkhe_Theme\Widget;

/**
 * ウィジェット登録
 */
add_action( 'widgets_init', __NAMESPACE__ . '\setup_widgets' );
function setup_widgets() {

	// 標準の「最新の投稿」ウィジェットを削除して上書き
	unregister_widget( 'wp_widget_recent_posts' );
	register_widget( '\Arkhe_Theme\Widget\Recent_Posts' );

	// ウィジェットエリアを登録
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'arkhe' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Widgets in this area will be displayed in the sidebar.', 'arkhe' ),
			'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="c-widget__title -side">',
			'after_title'   => '</div>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Bottom of Drawer menu', 'arkhe' ),
			'id'            => 'drawer-bottom',
			'description'   => __( 'Widgets in this area will be displayed in bottom of the drawer menu.', 'arkhe' ),
			'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="c-widget__title -spmenu">',
			'after_title'   => '</div>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'arkhe' ) . '1',
			'id'            => 'footer-1',
			'description'   => __( 'Widgets in this area will be displayed in the footer.', 'arkhe' ),
			'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="c-widget__title -footer">',
			'after_title'   => '</div>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'arkhe' ) . '2',
			'id'            => 'footer-2',
			'description'   => __( 'Widgets in this area will be displayed in the footer.', 'arkhe' ),
			'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="c-widget__title -footer">',
			'after_title'   => '</div>',
		)
	);
}

/**
 * 選択できないレガシーウィジェット選択可能にする
 */
add_filter( 'widget_types_to_hide_from_legacy_widget_block', __NAMESPACE__ . '\filter_hide_legacy_widget' );
function filter_hide_legacy_widget( $widget_types ) {
	/**
	 * コアのレガシーウィジェット："pages", "calendar", "archives", "media_audio", "media_image", "media_gallery", "media_video", "search", "text", "categories", "recent-posts", "recent-comments", "rss", "tag_cloud", "custom_html", "block"
	 */
	$widget_types = array_diff( $widget_types, array( 'search', 'custom_html', 'text', 'recent-posts', 'categories' ) );
	$widget_types = array_values( $widget_types );
	return $widget_types;
}
