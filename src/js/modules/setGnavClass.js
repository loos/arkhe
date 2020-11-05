import DOM from './data/domData';

const setCurrent = (nav) => {
	//-currentクラスをいったん削除
	const currentItem = nav.querySelector('li.-current');
	if (currentItem) currentItem.classList.remove('-current');

	// トップページのURL
	const homeUrl = window.arkheVars.homeUrl || '';

	//現在のURLを取得 （? や # はのぞいたもの）
	const nowHref = window.location.origin + window.location.pathname;

	// トップページは、カレントクラス付与しない
	if (homeUrl === nowHref) return;

	// 全liを取得
	const navItem = nav.querySelectorAll('.c-gnav > li');
	for (let i = 0; i < navItem.length; i++) {
		const li = navItem[i];

		const a = li.querySelector('a');
		const href = a.getAttribute('href');

		//現在のURLと一致していれば、-currentクラスを付与
		if (nowHref === href) {
			li.classList.add('-current');
		}
	}
};

/**
 * setGnavClass
 *
 */
export default function () {
	const gnav = DOM.gnav;
	if (null === gnav) return;
	// グロナビに -current つける
	setCurrent(gnav);

	const gnavMenu = gnav.querySelector('.c-gnav');

	if (null === gnavMenu) return false;

	const links = gnavMenu.getElementsByTagName('a');

	for (let i = 0; i < links.length; i++) {
		const link = links[i];
		link.addEventListener('focus', toggleFocus, true);
		link.addEventListener('blur', toggleFocus, true);
	}

	//Sets or removes the .focus class on an element.
	function toggleFocus() {
		let self = this;
		// console.log(self);

		// Move up through the ancestors of the current link until we hit .primary-menu.
		while (!self.classList.contains('c-gnav')) {
			// On li elements toggle the class .focus.
			if ('li' === self.tagName.toLowerCase()) {
				self.classList.toggle('focus');
			}
			self = self.parentElement;
		}
	}
}
