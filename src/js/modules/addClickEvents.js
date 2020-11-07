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
	// toggleIndex: function(e) {
	//     e.preventDefault();
	//     const indexModal = DOM.indexModal;
	//     if (null !== indexModal) indexModal.classList.toggle('is-open');
	// },

	/**
	 * アコーディオン
	 * 親のariaと兄弟要素のariaを制御。
	 */
	// toggleAccordion: function(e) {
	//     e.preventDefault();
	//     const acTitle = e.currentTarget;
	//     const acWrap = acTitle.parentNode;
	//     const acBody = acTitle.nextElementSibling;
	//     const acIcon = acTitle.lastElementChild;
	//     const isExpanded = acWrap.getAttribute('aria-expanded');
	//     if ('false' === isExpanded) {
	//         acWrap.setAttribute('aria-expanded', 'true');
	//         acBody.setAttribute('aria-hidden', 'false');
	//         acIcon.setAttribute('data-opened', 'true');
	//     } else {
	//         acWrap.setAttribute('aria-expanded', 'false');
	//         acBody.setAttribute('aria-hidden', 'true');
	//         acIcon.setAttribute('data-opened', 'false');
	//     }
	// },

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

	/**
	 * タブ
	 */
	tabControl(e) {
		e.preventDefault();

		// クリックイベントがキー（Enter / space）によって呼び出されたかどうか
		const iskeyClick = 0 === e.clientX;

		// クリックされたボタン要素
		const clickedButton = e.currentTarget;
		const isOpend = 'true' === clickedButton.getAttribute('aria-selected');

		if (!iskeyClick) {
			// マウスクリック時はフォーカスを外す
			clickedButton.blur();
		}
		if (isOpend)
			// すでにオープンされているタブの場合はなにもしない
			return;

		// 展開させるタブボックスを取得
		const targetID = clickedButton.getAttribute('aria-controls');
		const targetBox = document.getElementById(targetID);

		// すでに選択済みのタブボタンを取得 : closest('[aria-selected="true"]') だと取得できなかった。
		const parentTabList = clickedButton.closest('[role="tablist"]');
		const selectedButton = parentTabList.querySelector('[aria-selected="true"]');

		// すでに展開済みのタブボックスを取得
		const openedBox = targetBox.parentNode.querySelector('[aria-hidden="false"]');

		// ariaの処理
		clickedButton.setAttribute('aria-selected', 'true');
		selectedButton.setAttribute('aria-selected', 'false');
		targetBox.setAttribute('aria-hidden', 'false');
		openedBox.setAttribute('aria-hidden', 'true');
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
