import { Luminous, LuminousGallery } from 'luminous-lightbox';

/**
 * 除外対象の画像にデータ属性を付与
 */
function setLbOff() {
	const lbOffImgs = document.querySelectorAll('.u-lb-off img, img.u-lb-off');

	// 画像が一枚もなければreturn
	if (1 > lbOffImgs.length) return;

	lbOffImgs.forEach((img) => {
		img.setAttribute('data-luminous', 'off');
	});
}

/**
 * imgタグへLuminousに必要な属性データを付与する
 *
 * @returns bool
 */
const setDataLuminous = (img) => {
	// 除外対象として判定済みの画像はスキップ
	const dataLuminous = img.getAttribute('data-luminous');
	if ('off' === dataLuminous) return false;

	// 親がaタグの場合はスキップ
	const imgParent = img.parentNode;
	if ('A' === imgParent.tagName) {
		img.setAttribute('data-luminous', 'off');
		return false;
	}

	// すでに luminous クラスがついていればスキップ
	const imgClassName = img.className;
	if (-1 !== imgClassName.indexOf('luminous')) return false;

	// data-srcがあれば読み取る
	let src = img.getAttribute('data-src');
	if (!src) {
		// data-srcがなければ普通に src を取得
		src = img.getAttribute('src');
	}

	// 画像ソースなければ continue
	if (!src) return false;

	// フルサイズの画像パスを取得 luminousをセットする処理を開始
	const fullSizeSrc = src.replace(/-[0-9]*x[0-9]*\./, '.');

	img.setAttribute('data-luminous', fullSizeSrc);

	img.classList.add('luminous');

	return true;
};

/**
 * ギャラリーブロックに対する処理
 */
const setLuminousGallery = () => {
	// ギャラリーブロックの画像は先にグループ化して処理
	const galleys = document.querySelectorAll('.c-postContent .wp-block-gallery');

	// なければreturn
	if (1 > galleys.length) return;

	galleys.forEach((galley) => {
		const galleyImgs = [...galley.querySelectorAll('img')]; // NodeListを配列として取得

		galleyImgs.forEach((img, i) => {
			// Luminousのデータをセット
			if (!setDataLuminous(img)) {
				galleyImgs.splice(i, 1); // 除外対象だった画像を配列から削除
			}
		});

		if (0 < galleyImgs.length) {
			new LuminousGallery(
				galleyImgs,
				{ arrowNavigation: true },
				{ sourceAttribute: 'data-luminous' }
			);
		}
	});
};

/**
 * 普通の画像ブロックに対する処理
 */
const setLuminousImage = () => {
	const lbOnImgs = document.querySelectorAll(
		'.c-postContent .wp-block-image:not(.u-lb-off) img' // , .c-postContent img.u-lb-on
	);

	// 画像が一枚もなければreturn
	if (1 > lbOnImgs.length) {
		return;
	}

	lbOnImgs.forEach((img) => {
		if (setDataLuminous(img)) {
			// 無事にデータがセットできれば Luminou 発火
			new Luminous(img, {
				sourceAttribute: 'data-luminous',
			});
		}
	});
};

window.addEventListener('load', function () {
	setLbOff();
	setLuminousGallery();
	setLuminousImage();
});
