/**
 * 状態を管理する変数のオブジェクト
 */
export let headH = 0,
    adminbarH = 0,
    isPC = false, //PCサイズ以上
    isSP = false, // Tab縦「以下」( = !isPC)
    isMobile = false, // mobile以下
    isTab = false, //Tab縦「以上」か ( = !isMobile)
    smoothOffset = 0,
    // isMobile = window.isMobile,
    isFixHeadSP = window.isFixHeadSP;

export const ua = navigator.userAgent.toLowerCase();

export default {
    mediaSize: () => {
        isPC = 959 < window.innerWidth ? true : false;
        isMobile = 600 > window.innerWidth ? true : false;
        isSP = !isPC;
        isTab = !isMobile;
    },
    headH: (header) => {
        if (null !== header) {
            headH = header.offsetHeight;

            document.documentElement.style.setProperty('--header_height', headH + 'px');
            const headBody = header.querySelector('.l-header__body');
            if (null !== headBody) {
                const headBodyH = headBody.offsetHeight;
                document.documentElement.style.setProperty(
                    '--header_body_height',
                    headBodyH + 'px'
                );
            }
        }
    },
    adminbarH: (adminbar) => {
        if (null !== adminbar) {
            adminbarH = adminbar.offsetHeight;
        }
    },
    smoothOffset: () => {
        smoothOffset = 8; //初期値

        if (window.arkheVars === undefined) return;
        const arkheVars = window.arkheVars;

        if (isPC && arkheVars.isFixHeadPC) {
            // PC表示でヘッダー固定時
            smoothOffset += headH;
        } else if (isSP && arkheVars.isFixHeadSP) {
            // SP表示でヘッダー固定時
            smoothOffset += headH;
        }
        if (0 < adminbarH) {
            smoothOffset += adminbarH;
        }
    },
};
