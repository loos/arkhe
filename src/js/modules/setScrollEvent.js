/**
 * スクロールイベントを登録
 */
export default function setScrollEvent() {
	let scrTop = 0; // スクロール値
	let timeout = false;
	let ptFlag = true;
	const timer = null;
	window.addEventListener('scroll', function () {
		// clearTimeout(timer);
		if (timeout) return;
		timeout = true;
		setTimeout(function () {
			timeout = false;

			scrTop = window.pageYOffset;

			// スクロールされたかどうかをHTMLのdata属性にセット
			if (ptFlag && 160 <= scrTop) {
				document.documentElement.setAttribute('data-scrolled', 'true');
				ptFlag = false;
			} else if (!ptFlag && 160 > scrTop) {
				document.documentElement.setAttribute('data-scrolled', 'false');
				ptFlag = true;
			}
		}, 250);
	});
}
