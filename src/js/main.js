/**
 * DOMデータ
 */
import DOM from '@js/modules/data/domData';
import setDomData from '@js/modules/setDomData';

/**
 * 状態を管理する変数データ
 */
import { setState, smoothOffset, ua } from '@js/modules/data/stateData';

/**
 * モジュール読み込み
 */
import setScrollEvent from '@js/modules/setScrollEvent';
import setGnavClass from '@js/modules/setGnavClass';
import changeDeviceSize from '@js/modules/changeDeviceSize';
import addClickEvents from '@js/modules/addClickEvents';
import setEscEvent from '@js/modules/setEscEvent';
import setKeepFocus from '@js/modules/setKeepFocus';
import { smoothScroll, addSmoothScrollEvent } from '@js/modules/smoothScroll';

/**
 * FB内ブラウザのバグに対処
 */
const isFB = -1 !== ua.indexOf('fb');
if (isFB) {
	if (300 > window.innerHeight) {
		location.reload();
	}
	// console.log('a');
}

/**
 * 状態変数のセット
 */
setState.mediaSize();

/**
 * URLのハッシュ取得
 */
const urlHash = location.hash;

/**
 * Lazyloadへのフック
 * PCとSPで画像切り替える場合の処理
 */
// method.LazyHook(isPC);

/**
 * DOMContentLoaded
 */
document.addEventListener('DOMContentLoaded', function () {
	/* DOMデータを取得 */
	setDomData(DOM);

	/* ヘッダーの高さ取得 */
	setState.headH(DOM.header);

	/* アドミンバーの高さ取得 */
	setState.adminbarH(DOM.wpadminbar);

	/* smoothOffsetをセット */
	setState.smoothOffset(DOM.wpadminbar);

	// スクロールバーの幅
	setState.scrollbarW();

	/**
	 * objectFitImages
	 */
	if (window.objectFitImages) window.objectFitImages();

	/**
	 * スマホ・タブレット縦 と PC・タブレット横による分岐処理
	 */
	changeDeviceSize();

	/**
	 * グロナビに -current つける
	 */
	setGnavClass();

	/**
	 * クリックイベントをまとめて登録
	 */
	addClickEvents(document);

	/**
	 * スクロールイベント
	 */
	setScrollEvent();

	/**
	 * モーダル内のフォーカスキープ
	 */
	setKeepFocus();

	/**
	 * Esc処理
	 */
	setEscEvent();
});

window.addEventListener('load', function () {
	const arkheVars = window.arkheVars;

	// html のdata-loadedをセット
	document.documentElement.setAttribute('data-loaded', 'true');

	/* ヘッダーの高さ取得 */
	setState.headH(DOM.header);

	/* smoothOffsetをセット */
	setState.smoothOffset(DOM.wpadminbar);

	/**
	 * スムースリンクの処理を登録
	 *  !!! 目次リスト生成よりあとに !!!
	 */
	if ('on' === arkheVars.smoothScroll) {
		addSmoothScrollEvent();
	}

	// #つきリンクでページ遷移してきたときに明示的にスクロールさせる
	if (urlHash) {
		const targetID = urlHash.replace('#', '');
		const hashTarget = document.getElementById(targetID); // querySelectorは###などでエラーになる
		if (null !== hashTarget) smoothScroll(hashTarget, smoothOffset);
	}
});

/**
 * 画面回転時にも発火させる
 */
window.addEventListener('orientationchange', function () {
	// 縦・横サイズを正確に取得するために少しタイミングを遅らせる
	setTimeout(() => {
		/* 状態変数のセット */
		setState.mediaSize();

		/* ヘッダーの高さ取得 */
		setState.headH(DOM.header);

		/* smoothOffsetをセット */
		setState.smoothOffset(DOM.wpadminbar);

		/** スマホ・タブレット縦 と PC・タブレット横による分岐処理 */
		changeDeviceSize();
	}, 5);
});
