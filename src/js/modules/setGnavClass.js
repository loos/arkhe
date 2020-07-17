import DOM from './data/domData';

const setCurrent = (nav) => {
    if (null === nav) return;

    //-currentクラスをいったん削除
    const currentItem = nav.querySelector('li.-current');
    if (currentItem) currentItem.classList.remove('-current');

    // トップページは、カレントクラス付与しない
    const locationPath = window.location.pathname;
    if ('/' === locationPath) return;

    //現在のURLを取得 （? や # はをのぞいて）
    const nowHref = window.location.origin + locationPath;

    // 全liを取得
    const navItem = nav.querySelectorAll('.c-gnav > li');
    for (let i = 0; i < navItem.length; i++) {
        const li = navItem[i];

        const a = li.querySelector('a');
        const href = a.getAttribute('href');

        //現在のURLと一致していれば、-currentクラスを付与
        if (nowHref === href) {
            li.classList.add('-current');
        }
    }
};

/**
 * setGnavClass
 *   グロナビに -current つける
 */
export default function() {
    // クラス付与
    setCurrent(DOM.gnav);
}
