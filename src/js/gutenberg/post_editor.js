/**
 * FSEブロックの停止
 */
import { addFilter } from '@wordpress/hooks';
(function () {
	if (window.arkPostEditorVars.useFseBlocks) return;

	addFilter('blocks.registerBlockType', 'arkhe/filter-fse-blocks', function (settings, name) {
		if (!settings.supports) return settings;

		const fseBlocks = [
			'core/loginout',
			'core/navigation',
			'core/page-list',
			'core/post-author',
			'core/post-comments',
			'core/post-content',
			'core/post-date',
			'core/post-excerpt',
			'core/post-featured-image',
			'core/post-navigation-link',
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
			'core/term-description',
		];
		if (-1 !== fseBlocks.indexOf(name)) {
			settings.supports.inserter = false;
		}
		return settings;
	});
})();
