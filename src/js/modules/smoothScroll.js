import DOM from './data/domData';
import { isPC, smoothOffset } from './data/stateData';

/**
 * スムーススクロール関数
 *
 * @param target スクロール位置となる対象要素
 * @param offset    ヘッダーの高さなど、ターゲット座標の調整値
 * @param divisor    近づく割合（数値が大きいほどゆっくり近く）
 */
export function smoothScroll(target, offset, divisor) {
	divisor = divisor || 12;
	let toY;
	let nowY = window.pageYOffset; //現在のスクロール値
	const range = divisor / 2 + 1; //どこまで近づけば処理を終了するか(無限ループにならないように divisor から算出)

	//ターゲットの座標
	const targetRect = target.getBoundingClientRect(); //ターゲットの座標取得
	const targetY = targetRect.top + nowY - offset; //現在のスクロール値 & ヘッダーの高さを踏まえた座標
	//スクロール終了まで繰り返す処理
	const loopFunc = () => {
		toY = nowY + Math.round((targetY - nowY) / divisor); //次に移動する場所（近く割合は除数による。）
		window.scrollTo(0, toY); //スクロールさせる
		nowY = toY; //nowY更新

		if (document.body.clientHeight - window.innerHeight < toY) {
			//最下部にスクロールしても対象まで届かない場合は下限までスクロールして強制終了
			window.scrollTo(0, document.body.clientHeight);
			return;
		}
		if (toY >= targetY + range || toY <= targetY - range) {
			//+-rangeの範囲内へ近くまで繰り返す
			window.setTimeout(loopFunc, 10);
		} else {
			//+-range の範囲内にくれば正確な値へ移動して終了。
			window.scrollTo(0, targetY);
		}
	};
	loopFunc(); //初回実行;
}

/**
 * スムーススクロールイベントを登録する
 *
 * @param {*} dom #付きリンクを検索する親要素
 */
export function addSmoothScrollEvent(dom) {
	const root = dom || document;
	const linkElems = root.querySelectorAll('a[href*="#"]');
	for (let i = 0; i < linkElems.length; i++) {
		linkElems[i].addEventListener('click', function (e) {
			const href = e.currentTarget.getAttribute('href'); // href取得
			const splitHref = href.split('#');
			const targetID = splitHref[1];
			const target = document.getElementById(targetID); // リンク先の要素（ターゲット）取得

			if (target) {
				// e.preventDefault();
				smoothScroll(target, smoothOffset);

				// スマホメニューが開いていれば閉じる
				document.documentElement.setAttribute('data-drawer', 'closed');

				// 目次メニューが開いていれば閉じる
				const indexModal = DOM.indexModal;
				if (null !== indexModal && indexModal.classList.contains('is-open')) {
					indexModal.classList.remove('is-open');
				}
			} else {
				return true;
			}
			return false;
		});
	}
}
