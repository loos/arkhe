import DOM from './data/domData';
import { isModalOpen } from '@js/modules/data/stateData';

/* eslint no-lonely-if: 0 */

// モーダル内のフォーカス可能要素を取得
function getFocusableElements(modal) {
	if (!modal) return [];

	// Find all focusable children
	const focusableElemString = 'a[href], input, select, textarea, button, [tabindex="0"]';
	let focusableElements = modal.querySelectorAll(focusableElemString);

	// Convert NodeList to Array
	focusableElements = Array.prototype.slice.call(focusableElements);

	return focusableElements;
}

function setModalKeydownEvent(modal, focusableElements, modalType) {
	// The first focusable element within the modal window
	const firstTabStop = focusableElements[0];

	// The last focusable element within the modal window
	const lastTabStop = focusableElements[focusableElements.length - 1];

	// Focus the window
	// firstTabStop.focus();

	// Add keydown event
	modal.addEventListener('keydown', function (e) {
		if (!isModalOpen) return;

		// 現在アクティブなトグルボタンを取得
		let closeBtn = null;
		if ('drawer' === modalType) {
			closeBtn = DOM.drawerToggleBtn;
		}

		// 9 : Tab key
		if (9 === e.keyCode) {
			if (e.shiftKey) {
				// If Shift + Tab
				if (document.activeElement === firstTabStop) {
					// 最初の要素から戻ろうとする時 -> closeBtn or 最後の要素にフォーカス
					e.preventDefault();
					if (closeBtn) {
						closeBtn.focus();
					} else {
						lastTabStop.focus();
					}
				}
			} else {
				// if Tab key
				if (document.activeElement === lastTabStop) {
					// 最後の要素から進もうとする時 -> closeBtn or 最初の要素にフォーカス
					e.preventDefault();
					if (closeBtn) {
						closeBtn.focus();
					} else {
						firstTabStop.focus();
					}
				}
			}
		}
	});
}

/**
 * モーダルの外にクローズボタンがある場合に、クローズボタンにもkeydownイベントを登録する
 * （ドロワーメニュー用）
 */
function setBtnKeydownEvent(toggleBtns, focusableElements) {
	// The first focusable element within the modal window
	const firstTabStop = focusableElements[0];

	// The last focusable element within the modal window
	const lastTabStop = focusableElements[focusableElements.length - 1];

	toggleBtns.forEach(function (btn) {
		btn.addEventListener('keydown', function (e) {
			if (!isModalOpen) return;

			if (9 === e.keyCode) {
				if (document.activeElement === btn) {
					e.preventDefault();
					if (e.shiftKey) {
						// btn 戻ろうとする時 -> 最後の要素にフォーカス
						lastTabStop.focus();
					} else {
						// btn から進もうとする時 -> 最初の要素にフォーカス
						firstTabStop.focus();
					}
				}
			}
		});
	});
}

// モーダル内でフォーカスをキープする
export default function (modal, closeBtn) {
	// ドロワーモーダルのフォーカス可能要素を取得
	const drawerFocusableElements = getFocusableElements(DOM.drawerMenu);

	// ドロワーモーダルのフォーカスイベント
	setModalKeydownEvent(DOM.drawerMenu, drawerFocusableElements, 'drawer');

	// ドロワートグルボタンのフォーカスイベント
	const drawerToggleBtns = document.querySelectorAll('.c-iconBtn[data-onclick="toggleMenu"]');
	setBtnKeydownEvent(drawerToggleBtns, drawerFocusableElements);

	// ---

	// 検索モーダルのフォーカス可能要素を取得
	const searchFocusableElements = getFocusableElements(DOM.searchModal);

	// 検索モーダルのフォーカスイベント
	setModalKeydownEvent(DOM.searchModal, searchFocusableElements, 'search');

	// 検索トグルボタンのフォーカスイベント
	// const searchToggleBtns = document.querySelectorAll('[data-onclick="toggleSearch"]');
	// setBtnKeydownEvent(searchToggleBtns, searchFocusableElements);
}
