// import DOM from './data/domData';
import { smoothOffset } from './data/stateData';

/**
 * スムーススクロール関数
 *
 * @param  target スクロール位置となる対象要素 or 座標数値
 * @param  offset ヘッダーの高さなど、ターゲット座標の調整値
 */
export function smoothScroll( target, offset ) {
	// アニメーションの開始時のスクロール位置を格納する変数
	const startY = window.scrollY;

	let targetY = 0;
	//ターゲットの座標
	if ( Number.isInteger( target ) ) {
		// 直接指定された場合
		targetY = target;
	} else {
		const targetRect = target.getBoundingClientRect(); //ターゲットの座標取得
		targetY = targetRect.top + startY - offset; //現在のスクロール値 & ヘッダーの高さを踏まえた座標
		if ( targetY < 0 ) targetY = 0;
	}

	// アニメーションの開始時間を格納する変数
	let startTime = null;

	// アニメーションの Duration の設定
	let duration = 500;

	// 距離に応じてスクロール時間を調整する
	const distance = Math.abs( targetY - startY );
	if ( 10000 < distance ) {
		duration = 1500;
	} else if ( 5000 < distance ) {
		duration = 1000;
	} else if ( 1000 < distance ) {
		duration = 750;
	}

	/**
	 * イージング関数 https://easings.net/ja
	 */
	const easeOutCubic = ( x ) => {
		return 1 - Math.pow( 1 - x, 3 );
	};

	/**
	 * アニメーションの各フレームでの処理
	 *
	 * @param  nowTime コールバックの呼び出しを開始した時点の時刻 ( performance.now() )
	 */
	const scrollAnimation = ( nowTime ) => {
		// 経過時間
		const elapsedTime = nowTime - startTime;

		// 進捗率
		const progress = Math.min( 1, elapsedTime / duration );

		// 次のスクロール位置
		const nextY = startY + ( targetY - startY ) * easeOutCubic( progress );

		// 指定した位置へスクロール
		window.scrollTo( 0, nextY );

		// 進捗率が1未満の場合、自分自身を呼び出し、繰り返す
		if ( progress < 1 ) {
			requestAnimationFrame( scrollAnimation );
		}
	};

	startTime = performance.now();
	scrollAnimation( startTime );
}

/**
 * スムーススクロールイベントを登録する
 *
 * @param {*} dom #付きリンクを検索する親要素
 */
export function addSmoothScrollEvent( dom ) {
	const root = dom || document;
	const linkElems = root.querySelectorAll( 'a[href*="#"]' );
	for ( let i = 0; i < linkElems.length; i++ ) {
		linkElems[ i ].addEventListener( 'click', function ( e ) {
			const href = e.currentTarget.getAttribute( 'href' ); // href取得
			const splitHref = href.split( '#' );
			const targetID = splitHref[ 1 ];
			const target = document.getElementById( targetID ); // リンク先の要素（ターゲット）取得

			if ( target ) {
				// e.preventDefault();
				smoothScroll( target, smoothOffset );

				// スマホメニューが開いていれば閉じる
				document.documentElement.setAttribute( 'data-drawer', 'closed' );

				// 目次メニューが開いていれば閉じる
				// const indexModal = DOM.indexModal;
				// if (null !== indexModal && indexModal.classList.contains('is-open')) {
				// 	indexModal.classList.remove('is-open');
				// }
			} else {
				return true;
			}
			return false;
		} );
	}
}
