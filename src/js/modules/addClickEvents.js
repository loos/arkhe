import DOM from './data/domData';
import { setState } from '@js/modules/data/stateData';

/**
 * クリックイベント処理をまとめたオブジェクト
 */
export const clickEvents = {
	pageTop() {
		const thisFunc = clickEvents.pageTop;
		const nowY = window.pageYOffset;
		window.scrollTo(0, Math.floor(nowY * 0.8));
		if (0 < nowY) {
			window.setTimeout(thisFunc, 10);
		}
	},
	toggleMenu(e) {
		e.preventDefault();

		const drawerMenu = DOM.drawerMenu;
		if (null === drawerMenu) return false;

		// マウスクリックで発火したイベントかどうか
		const isMouseClicked = 0 !== e.screenX && 0 !== e.screenY;

		// クリックされたドロワーメニューのトグルボタンをセット
		const theToggleBtn = e.currentTarget;
		DOM.drawerToggleBtn = theToggleBtn;

		const dataDrower = document.documentElement.getAttribute('data-drawer');
		if ('opened' !== dataDrower) {
			// オープン処理
			document.documentElement.setAttribute('data-drawer', 'opened');
			setState.modalOpen(true);

			// クリックしたボタンを記憶
			DOM.lastFocusedElem = theToggleBtn;
		} else {
			// クローズ処理
			document.documentElement.setAttribute('data-drawer', 'closed');

			// キー操作でクローズした場合、元のボタンにフォーカスを戻す
			if (!isMouseClicked && DOM.lastFocusedElem) {
				DOM.lastFocusedElem.focus();
				DOM.lastFocusedElem = null;
				setState.modalOpen(false);
			}
		}
	},
	toggleSearch(e) {
		e.preventDefault();

		const searchModal = DOM.searchModal;
		if (null === searchModal) return false;

		// マウスクリックで発火したイベントかどうか
		const isMouseClicked = 0 !== e.screenX && 0 !== e.screenY;

		// クリックされた検索トグルボタンをセット
		const theToggleBtn = e.currentTarget;
		// DOM.searchToggleBtn = theToggleBtn;

		if (!searchModal.classList.contains('is-open')) {
			// オープン処理
			searchModal.classList.add('is-open');
			setState.modalOpen(true);

			// クリックしたボタンを記憶
			DOM.lastFocusedElem = theToggleBtn;

			// 入力エリアにフォーカス
			setTimeout(() => {
				searchModal.querySelector('[name="s"]').focus();
			}, 250);
		} else {
			// クローズ処理
			searchModal.classList.remove('is-open');

			// キー操作でクローズした場合、元のボタンにフォーカスを戻す
			if (!isMouseClicked && DOM.lastFocusedElem) {
				DOM.lastFocusedElem.focus();
				DOM.lastFocusedElem = null;
				setState.modalOpen(false);
			}
		}
	},

	/**
	 * サブメニューのアコーディオン
	 */
	toggleSubmenu(e) {
		e.preventDefault();
		const btn = e.currentTarget;
		const submenu = btn.parentNode.nextElementSibling;

		btn.classList.toggle('is-opened');
		submenu.classList.toggle('is-opened');

		e.stopPropagation();
	},
};

/**
 * data-onclick属性を持つ要素にクリックイベントを登録
 *
 * @param {*} dom 該当要素を検索する親（ AJAXで読み込んだ要素からも探せるように引数化 ）
 */
export default function addClickEvents(dom) {
	const elemsHasClickEvent = dom.querySelectorAll('[data-onclick]');
	for (let i = 0; i < elemsHasClickEvent.length; i++) {
		const elem = elemsHasClickEvent[i];
		if (elem) {
			const funcName = elem.getAttribute('data-onclick');
			const clickFunc = clickEvents[funcName];
			elem.addEventListener('click', function (e) {
				clickFunc(e);
			});
		}
	}
}
