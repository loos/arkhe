<?php
namespace Arkhe_Theme\Gutenberg;

/**
 * 使用可能なブロックの制御
 */
add_filter( 'allowed_block_types_all', __NAMESPACE__ . '\limit_block_types', 99, 2 );
function limit_block_types( $allowed_block_types, $block_editor_context ) {

	$allowed_blocks = array();
	if ( is_array( $allowed_block_types ) && ! empty( $allowed_block_types ) ) {
		// すでに許可リストがある場合
		$allowed_blocks = $allowed_block_types;
	} else {
		// まだ空だったら全ブロック取得
		$block_types = \WP_Block_Type_Registry::get_instance()->get_all_registered();
		foreach ( $block_types as $block_type ) {
			$allowed_blocks[] = $block_type->name;
		}
	}

	$FSE_blocks = array(
		'core/loginout',
		'core/page-list',
		'core/post-content',
		'core/post-date',
		'core/post-excerpt',
		'core/post-featured-image',
		'core/post-terms',
		'core/post-title',
		'core/post-template',
		'core/query-loop',
		'core/query',
		'core/query-pagination',
		'core/query-pagination-next',
		'core/query-pagination-numbers',
		'core/query-pagination-previous',
		'core/query-title',
		'core/site-logo',
		'core/site-title',
		'core/site-tagline',
	);

	$disallowed_blocks = array();

	global $hook_suffix;
	if ( 'widgets.php' === $hook_suffix || 'customize.php' === $hook_suffix ) {
		// ウィジェットではFSE & more / nextpage も オフ。
		$disallowed_blocks = array_merge( $FSE_blocks, array(
			'core/more',
			'core/nextpage',
		) );
	} else {
		// その他、FSEオフ
		$disallowed_blocks = $FSE_blocks;
	}

	$allowed_blocks = array_diff( $allowed_blocks, $disallowed_blocks );
	$allowed_blocks = array_values( $allowed_blocks ); // array_valuesちゃんとしないと効かない
	return $allowed_blocks;
}
