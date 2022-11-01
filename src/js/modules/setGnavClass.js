import DOM from './data/domData';

const setCurrent = ( nav ) => {
	//-currentクラスをいったん削除
	const currentItem = nav.querySelector( 'li.-current' );
	if ( currentItem ) currentItem.classList.remove( '-current' );

	// トップページのURL
	const homeUrl = window.arkheVars.homeUrl || '';

	//現在のURLを取得 （? や # はのぞいたもの）
	const nowHref = window.location.origin + window.location.pathname;

	// トップページは、カレントクラス付与しない
	if ( homeUrl === nowHref ) return;

	// 全liを取得
	const navItem = nav.querySelectorAll( '.c-gnav > li' );
	for ( let i = 0; i < navItem.length; i++ ) {
		const li = navItem[ i ];

		const a = li.querySelector( 'a' );
		const href = a.getAttribute( 'href' );

		//現在のURLと一致していれば、-currentクラスを付与
		if ( nowHref === href ) {
			li.classList.add( '-current' );
		}
	}
};

/**
 * setGnavClass
 *
 */
export default function () {
	const gnav = DOM.gnav;
	if ( null === gnav ) return;
	// グロナビに -current つける
	setCurrent( gnav );

	const gnavMenu = gnav.querySelector( '.c-gnav' );
	if ( null === gnavMenu ) return false;

	// .c-gnav内のaをすべて取得
	const links = gnavMenu.getElementsByTagName( 'a' );

	for ( let i = 0; i < links.length; i++ ) {
		const link = links[ i ];
		link.addEventListener( 'focus', toggleFocus, true );
		link.addEventListener( 'blur', toggleFocus, true );
	}

	// タブキーでの操作中も、サブメニューが表示されるように .focus クラスを管理する
	function toggleFocus() {
		let self = this;
		// console.log(self);

		// c-gnav範囲内で、 li の .focus クラスを管理
		while ( ! self.classList.contains( 'c-gnav' ) ) {
			if ( 'li' === self.tagName.toLowerCase() ) {
				self.classList.toggle( 'focus' );
			}
			self = self.parentElement;
		}
	}
}
