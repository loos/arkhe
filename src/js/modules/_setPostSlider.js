// import DOM from './data/domData';
import { isPC } from '@js/modules/data/stateData';

/**
 * 記事スライダーをセットする関数
 * ! postSliderがあるときにだけ呼び出されるように !
 *
 * @param {*} postSlider
 */
export default function setPostSlider(postSlider) {
	const swiperContainer = postSlider.querySelector('.swiper-container');
	if (null === swiperContainer) {
		// もしスライダークラスが見つからなければ
		postSlider.classList.add('show_');
		return;
	}

	const swipeOption = {
		loop: true,
		effect: 'slider',
		autoplay: {
			delay: parseInt(window.psDelay) || 10000,
			disableOnInteraction: false,
		},
		speed: parseInt(window.psSpeed) || 1200,
		pagination: {
			el: '.p-postSlider .swiper-pagination',
			clickable: true,
		},
		navigation: {
			nextEl: '.p-postSlider .swiper-button-next',
			prevEl: '.p-postSlider .swiper-button-prev',
		},
		runCallbacksOnInit: true,
		on: {
			init() {
				setTimeout(() => {
					const thumb = postSlider.querySelector('.p-postList__thumb');
					if (thumb) {
						const thumbHelfH = thumb.offsetHeight / 2;
						const prevNav = postSlider.querySelector('.swiper-button-prev');
						const nextNav = postSlider.querySelector('.swiper-button-next');
						if (prevNav && nextNav) {
							prevNav.style.top = thumbHelfH + 'px';
							nextNav.style.top = thumbHelfH + 'px';
						}
					}
					postSlider.classList.add('show_');
				}, 10);
			},
		},
	};

	const sliderNum = isPC ? parseFloat(window.psNum) : parseFloat(window.psNumSp);
	swipeOption.slidesPerView = sliderNum;
	swipeOption.spaceBetween = 0;
	swipeOption.centeredSlides = true;
	// if (1 === sliderNum % 2) {
	//     // スライドの枚数が奇数なら
	//     let prevButton = postSlider.querySelector('.swiper-button-prev');
	//     let nextButton = postSlider.querySelector('.swiper-button-next');
	//     if (prevButton) {
	//         prevButton.style.left = '8px';
	//     }
	//     if (nextButton) {
	//         nextButton.style.right = '8px';
	//     }
	// }

	new Swiper(swiperContainer, swipeOption);
}
