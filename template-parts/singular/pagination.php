<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿・固定ページのページャー （改ページ）
 */
wp_link_pages( [
	'before'           => '<div class="pagination">',
	'after'            => '</div>',
	'next_or_number'   => 'number',
	//'pagelink'         => '<span>%</span>',
] );
