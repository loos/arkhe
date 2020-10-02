/**
 * DOMデータ
 */
// import DOM from '@js/modules/data/domData';

export default function setDomData(DOM) {
	DOM.header = document.getElementById('header');
	DOM.gnav = document.getElementById('gnav');
	DOM.drawerMenu = document.getElementById('drawer_menu');
	DOM.wpadminbar = document.getElementById('wpadminbar');
	DOM.mainContent = document.getElementById('main_content');
	DOM.sidebar = document.getElementById('sidebar');
	DOM.fixBottomMenu = document.getElementById('fix_bottom_menu');
	DOM.pageTopBtn = document.getElementById('pagetop');
	DOM.searchModal = document.getElementById('search_modal');
	DOM.indexModal = document.getElementById('index_modal'); // テーマ本体にはない。
}
