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
		isSP = ! isPC;
		isTab = ! isMobile;
	},
	headH: ( header ) => {
		if ( null !== header ) {
			headH = header.offsetHeight;

			document.documentElement.style.setProperty( '--ark-header_height', headH + 'px' );
		}
	},
	adminbarH: ( adminbar ) => {
		if ( null !== adminbar ) {
			adminbarH = adminbar.offsetHeight;
		}
	},
	modalOpen: ( val ) => {
		isModalOpen = val;
	},
	smoothOffset: () => {
		let fixedHeaderHeight = 0;

		const arkheVars = window.arkheVars;
		if ( arkheVars === undefined ) return;

		/* eslint no-lonely-if: off */
		// PC
		if ( isPC ) {
			// ヘッダー固定時
			if ( arkheVars.isFixHeadPC ) {
				fixedHeaderHeight += headH;
			}

			// グロナビー固定時
			if ( arkheVars.fixGnav ) {
				const headerUnder = document.querySelector( '.l-headerUnder' );
				if ( null !== headerUnder ) fixedHeaderHeight += headerUnder.offsetHeight;
			}
		} else {
			// SP表示でヘッダー固定時
			if ( arkheVars.isFixHeadSP ) {
				fixedHeaderHeight += headH;
			}
		}

		// CSS変数にセット
		document.documentElement.style.setProperty(
			'--ark-header_height--fixed',
			fixedHeaderHeight + 'px'
		);

		// スムーススクロール用のオフセット値
		smoothOffset = 8 + fixedHeaderHeight + adminbarH;
	},
	scrollbarW: () => {
		const scrollbarW = window.innerWidth - document.body.clientWidth;
		document.documentElement.style.setProperty( '--ark-scrollbar_width', scrollbarW + 'px' );
	},
};
