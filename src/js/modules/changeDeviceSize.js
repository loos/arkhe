import DOM from '@js/modules/data/domData';
import { isPC, isSP, isTab, isMobile } from '@js/modules/data/stateData';

/**
 * 固定フッターメニューがあれば footerの下に余白つける
 */
const setFooterPaddingBottom = (fixBottomMenu) => {
	const footer = document.getElementById('footer');
	if (null !== footer) {
		if (isPC) {
			footer.style.paddingBottom = '0';
		} else {
			const fixMenuH = fixBottomMenu.offsetHeight;
			footer.style.paddingBottom = fixMenuH + 'px';
		}
	}
};

/**
 * 向きが変わった時の処理
 */
export default function () {
	const wpadminbar = DOM.wpadminbar;

	// アドミンバーの有無による処理
	// if (null !== wpadminbar) {
	// fixBar.style.marginTop = '32px';
	// }

	// 固定フッターメニューがあれば footerの下に余白つける
	if (null !== DOM.fixBottomMenu) {
		setFooterPaddingBottom(DOM.fixBottomMenu);
	}
}
