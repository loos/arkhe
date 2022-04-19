<?php
namespace Arkhe_Theme\Gutenberg;

// ウィジェットグループのタイトルのhtml書き換える → 5.9.1あたりで不要になった
// add_filter( 'render_block_core/widget-group', __NAMESPACE__ . '\render_core_widget_group', 10, 2 );
// function render_core_widget_group( $block_content, $block ) {
// 	$block_content = preg_replace( '/<h2 class="widget-title">(.*?)<\/h2>/i', '<div class="c-widget__title">$1</div>', $block_content );
// 	return $block_content;
// }
