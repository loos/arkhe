import { Luminous, LuminousGallery } from "luminous-lightbox";

/**
 * 除外対象の画像にデータ属性を付与
 */
function setLbOff() {
	const lbOffs = document.querySelectorAll(".u-lb-off");
	if (!lbOffs.length) return;

	lbOffs.forEach((lbOff) => {
		// lbOffが img タグなら data-luminous 属性を off に。
		if ("IMG" === lbOff.tagName) {
			lbOff.setAttribute("data-luminous", "off");
			return;
		}

		// そうでなければ子要素の img を探す して data-luminous 属性を off に。
		const imgs = lbOff.querySelectorAll("img");

		imgs.forEach((img) => {
			img.setAttribute("data-luminous", "off");
		});
	});
}

/**
 * imgタグへLuminousに必要な属性データを付与する
 *
 * @returns bool
 */
const setDataLuminous = (img) => {
	// 除外対象として判定済みの画像はスキップ
	const dataLuminous = img.getAttribute("data-luminous");
	if ("off" === dataLuminous) return false;

	// 親がaタグの場合はスキップ
	const imgParent = img.parentNode;
	if ("A" === imgParent.tagName) {
		img.setAttribute("data-luminous", "off");
		return false;
	}

	// 親が .wp-lightbox-container の場合(コアのlightbox機能がONの画像)はスキップ
	if (imgParent.classList.contains("wp-lightbox-container")) {
		img.setAttribute("data-luminous", "off");
		return false;
	}

	// すでに luminous クラスがついていればスキップ
	const imgClassName = img.className;
	if (-1 !== imgClassName.indexOf("luminous")) return false;

	// data-srcがあれば読み取る
	let src = img.getAttribute("data-src");
	if (!src) {
		// data-srcがなければ普通に src を取得
		src = img.getAttribute("src");
	}

	// 画像ソースなければ continue
	if (!src) return false;

	// フルサイズの画像パスを取得 luminousをセットする処理を開始
	const fullSizeSrc = src.replace(/-[0-9]*x[0-9]*\./, ".");

	img.setAttribute("data-luminous", fullSizeSrc);

	img.classList.add("luminous");

	return true;
};

/**
 * ギャラリーブロックに対する処理
 */
const setLuminousGallery = () => {
	// ギャラリーブロックの画像は先にグループ化して処理
	const galleys = document.querySelectorAll(".c-postContent .wp-block-gallery");

	// なければreturn
	if (1 > galleys.length) return;

	galleys.forEach((galley) => {
		const galleyImgs = [...galley.querySelectorAll("img")]; // NodeListを配列として取得

		// Luminousのデータをセットできる画像だけを抽出
		const luminousImgs = galleyImgs.filter((img) => {
			return setDataLuminous(img);
		});

		if (0 < luminousImgs.length) {
			new LuminousGallery(
				luminousImgs,
				{ arrowNavigation: true },
				{ sourceAttribute: "data-luminous" }
			);
		}
	});
};

/**
 * 普通の画像ブロックに対する処理
 */
const setLuminousImage = () => {
	const lbOnImgs = document.querySelectorAll(
		".c-postContent .wp-block-image:not(.u-lb-off) img" // , .c-postContent img.u-lb-on
	);

	// 親チェックはここでしてもいいかもしれない。 親が a or .wp-lightbox-container なら削除？

	// 画像が一枚もなければreturn
	if (1 > lbOnImgs.length) {
		return;
	}

	lbOnImgs.forEach((img) => {
		if (setDataLuminous(img)) {
			// 無事にデータがセットできれば Luminou 発火
			new Luminous(img, {
				sourceAttribute: "data-luminous",
			});
		}
	});
};

window.addEventListener("load", function () {
	setLbOff();
	setLuminousGallery();
	setLuminousImage();
});
