/**
 * 状態を管理する変数のオブジェクト
 */
export let headH = 0,
	adminbarH = 0,
	isPC = false, //PCサイズ以上
	isSP = false, // Tab縦「以下」( = !isPC)
	isMobile = false, // mobile以下
	isTab = false, //Tab縦「以上」か ( = !isMobile)
	isModalOpen = false,
	smoothOffset = 0;

export const ua = navigator.userAgent.toLowerCase();

export const setState = {
	mediaSize: () => {
		isPC = 999 < window.innerWidth ? true : false;
		isMobile = 600 > window.innerWidth ? true : false;
		isSP = !isPC;
		isTab = !isMobile;
	},
	headH: (header) => {
		if (null !== header) {
			headH = header.offsetHeight;

			document.documentElement.style.setProperty('--ark-header_height', headH + 'px');
		}
	},
	adminbarH: (adminbar) => {
		if (null !== adminbar) {
			adminbarH = adminbar.offsetHeight;
		}
	},
	modalOpen: (val) => {
		isModalOpen = val;
	},
	smoothOffset: () => {
		smoothOffset = 8; //初期値

		const arkheVars = window.arkheVars;
		if (arkheVars === undefined) return;

		// PC表示でヘッダー固定時
		if (isPC && arkheVars.isFixHeadPC) {
			smoothOffset += headH;
		}

		// PC表示でグロナビー固定時
		if (isPC && arkheVars.fixGnav) {
			const headerUnder = document.querySelector('.l-headerUnder');
			if (null !== headerUnder) smoothOffset += headerUnder.offsetHeight;
		}

		// SP表示でヘッダー固定時
		if (isSP && arkheVars.isFixHeadSP) {
			smoothOffset += headH;
		}

		// 管理バーがある時
		if (0 < adminbarH) {
			smoothOffset += adminbarH;
		}

		// CSS変数にもセット
		document.documentElement.style.setProperty('--ark-offset_y', smoothOffset + 'px');
	},
	scrollbarW: () => {
		const scrollbarW = window.innerWidth - document.body.clientWidth;
		document.documentElement.style.setProperty('--ark-scrollbar_width', scrollbarW + 'px');
	},
};
