/**
 * FSEブロックの停止
 */
import { addFilter } from '@wordpress/hooks';
( function () {
	if ( window.arkPostEditorVars.useFseBlocks ) return;

	addFilter( 'blocks.registerBlockType', 'arkhe/filter-fse-blocks', function ( settings, name ) {
		if ( ! settings.supports ) return settings;

		if ( 'theme' === settings.category ) {
			// テーマカテゴリーの（FSE用）ブロックは削除
			settings.supports.inserter = false;
		} else {
			const fseBlocks = [
				// 「デザイン」カテゴリにあるもの
				'core/post-template',
				'core/query-pagination',
			];
			if ( -1 !== fseBlocks.indexOf( name ) ) {
				settings.supports.inserter = false;
			}
		}

		return settings;
	} );
} )();
