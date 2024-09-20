<?php
namespace Arkhe_Theme\Gutenberg;

// ウィジェットグループのタイトルのhtml書き換える → 5.9.1あたりで不要になった
// add_filter( 'render_block_core/widget-group', __NAMESPACE__ . '\render_core_widget_group', 10, 2 );
// function render_core_widget_group( $block_content, $block ) {
// 	$block_content = preg_replace( '/<h2 class="widget-title">(.*?)<\/h2>/i', '<div class="c-widget__title">$1</div>', $block_content );
// 	return $block_content;
// }


/**
 * 6.3で画像ブロックにstyleでw,hが指定されるようになったので、それをaspect-ratioに変換する
 */
add_filter( 'render_block_core/image', __NAMESPACE__ . '\fix_img_v63', 10, 2 );
function fix_img_v63( $block_content, $block ) {
	$attrs = $block['attrs'] ?? array();

	$w = $attrs['width'] ?? '';
	$h = $attrs['height'] ?? '';
	if ( $w && $h ) {
		$size_style    = "width:{$w}px;height:{$h}px";
		$ratio         = "{$w}/{$h}";
		$block_content = str_replace( $size_style, "aspect-ratio:{$ratio}", $block_content );
	}
	return $block_content;
}
