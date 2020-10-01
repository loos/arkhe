// import wrap from './wrap';
/**
 * Luminousをセット
 */
export default function setLuminous() {
	const contentImgs = document.querySelectorAll('.c-postContent img');
	for (let i = 0; i < contentImgs.length; i++) {
		// 画像データ
		const img = contentImgs[i];
		const imgClassName = img.className;
		const imgParent = img.parentNode;

		// lazyloadが有効であればdata-srcを読み取る
		const srcAttr = -1 !== imgClassName.indexOf('lazyload') ? 'data-src' : 'src';
		const imgSrc = img.getAttribute(srcAttr);

		// 画像ソースなければ continue
		if (!imgSrc) continue;

		// 親がaタグの場合や、親に特定のクラスが付いていれば continue
		// const ignoreRegex = /post_thumb_img/;
		// ignoreRegex.test(imgClassName)
		if ('A' === imgParent.tagName) {
			continue;
		}

		// 画像に -no-lb がついていれば continue
		if (-1 !== imgClassName.indexOf('-no-lb')) {
			continue;
		}

		// luminousをセットする処理を開始
		const imgFullSrc = imgSrc.replace(/-[0-9]*x[0-9]*\./, '.');

		img.classList.add('luminous');
		img.setAttribute('data-luminous', imgFullSrc);
		// img.setAttribute('title', 'クリックで拡大します');

		// Luminou発動
		new Luminous(img, {
			sourceAttribute: 'data-luminous',
		});
	}
}
