import DOM from './data/domData';
import { isPC, isMobile, headH, adminbarH } from './data/stateData';

/**
 * フルスクリーン時の高さセット : スライダー & 動画であり得る
 * @param {*} mainVisual
 * @param {*} mvInner
 */
const setFullScreenHeight = (mainVisual, mvInner) => {
    let offsetH = 0;
    const header = DOM.header;
    const infoBar = document.querySelector('.c-infoBar');

    //offsetHを計算：フルワイド幅からどれだけ引くか
    const isOverlay = header.getAttribute('data-overlay');
    if (isOverlay) {
        offsetH += headH;
    }
    //お知らせバーの高さを取得
    if (infoBar) {
        offsetH += infoBar.offsetHeight;
    }

    // margin
    if (mainVisual.classList.contains('-margin-on')) {
        offsetH = isMobile ? offsetH + 16 : offsetH + 32;
    }
    if (DOM.wpadminbar) {
        offsetH += adminbarH;
    }

    const mvInnerH = window.innerHeight - offsetH;
    mvInner.style.height = mvInnerH + 'px';
};

/**
 * フルスクリーン時の高さセット : スライダー & 動画であり得る
 * @param {*} mainVisual
 * @param {*} mvInner
 */
const setMvSlider = (mainVisual, mvInner) => {
    let swiperOpt = {
        loop: true,
        autoplay: {
            delay: parseInt(window.mvSlideDelay) || 10000,
            disableOnInteraction: false,
        },
        speed: parseInt(window.mvSlideSpeed) || 1200,
        pagination: {
            el: '.p-mainVisual .swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.p-mainVisual .swiper-button-next',
            prevEl: '.p-mainVisual .swiper-button-prev',
        },
        runCallbacksOnInit: true,
        on: {
            init: function() {
                setTimeout(() => {
                    mvInner.classList.add('show_');
                }, 10);
            },
        },
    };

    // swiperオプション上書き
    let slidesPV = isMobile ? window.mvSlideNumSp : window.mvSlideNum;
    slidesPV = parseFloat(slidesPV);

    //スライド表示枚数による分岐
    if (1 < slidesPV) {
        swiperOpt.slidesPerView = slidesPV;
        swiperOpt.effect = 'slider';
        swiperOpt.spaceBetween = 8;
        swiperOpt.centeredSlides = true;
        if (!mainVisual.classList.contains('-margin-on')) {
            mvInner.style.paddingTop = '8px';
            mvInner.style.paddingBottom = '8px';
        }
    } else {
        const slideEffect = 'slide' === window.mvSlideEffect ? 'slide' : 'fade';
        swiperOpt.effect = slideEffect;
    }

    new Swiper(mvInner, swiperOpt);
};

/**
 * メインビジュアルをセットする関数
 *  main.jsからは mainVisual があるときにしか呼び出されないようにしている
 * @param {*} mainVisual
 */
export function mvSet(mainVisual) {
    const mvInner = mainVisual.querySelector('.p-mainVisual__inner');

    if (mainVisual.classList.contains('-height-full')) {
        // フルスクリーンの時の処理
        setFullScreenHeight(mainVisual, mvInner);
    }

    if (mainVisual.classList.contains('-type-slider')) {
        // 画像スライダーのときの処理
        setMvSlider(mainVisual, mvInner);
    } else if (mainVisual.classList.contains('-type-movie')) {
        // 動画埋め込み時の処理...
        const mvVideo = mainVisual.querySelector('.p-mainVisual__video');
        if (null === mvVideo) return;
        const media = isPC ? 'pc' : 'sp';
        const videoPoster = mvVideo.getAttribute(`data-poster-${media}`);
        if (videoPoster) mvVideo.setAttribute('poster', videoPoster);
        const videoSource = mvVideo.querySelector('source');
        const videoSrc = videoSource.getAttribute(`data-src-${media}`);
        videoSource.setAttribute('src', videoSrc);
        mvVideo.load();
    }
}
