import DOM from './data/domData';
import { setState, isModalOpen } from '@js/modules/data/stateData';

/**
 * Escキーを押した時の処理
 */
export default function setEscEvent() {
	document.addEventListener('keydown', function (e) {
		if (27 === e.keyCode && isModalOpen) {
			e.preventDefault();
			// ドロワーメニュー閉じる
			document.documentElement.setAttribute('data-drawer', 'closed');

			// モーダルを閉じる
			document.querySelectorAll('.c-modal.is-open').forEach(function (elem) {
				elem.classList.remove('is-open');
			});

			if (DOM.lastFocusedElem) {
				DOM.lastFocusedElem.focus();
				DOM.lastFocusedElem = null;
			}

			setState.modalOpen(false);
		}
	});
}
