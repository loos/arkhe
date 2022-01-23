module.exports = {
    // stylelint 14への乗り換えで必要だと書かれていたがなくても動く...？
    // overrides: [
    //     {
    //       files: ["**/*.scss"],
    //       customSyntax: "postcss-scss"
    //     }
    //   ],
    extends: [
        '@wordpress/stylelint-config/scss',
        'stylelint-config-rational-order',
    ],
    ignoreFiles: ['./src/js/**/*.js', './**/plugins/*.scss','./assets/**/*.css'],
    rules: {
        'max-line-length': null, //max文字数を無視
        'length-zero-no-unit': null,
        // 'length-zero-no-unit': [ true, {ignore: ["custom-properties"]} ],
        'selector-class-pattern': null,
        // 'string-quotes': 'double', //ダブルクォーテーションに (wordpress でそうなってる)
        // 'no-duplicate-selectors': null, //同じセレクタの出現に関するエラーを出さない
        'function-url-quotes': 'never', //不必要なクォーテーションを禁止( これだけ自動Fixできない )
        'no-descending-specificity': null, //セレクタの詳細度に関する警告を出さない
        'number-leading-zero': 'never', //0.5emなどは.5emに
        'font-weight-notation': null, //font-weightの指定は自由
        'font-family-no-missing-generic-family-keyword': null, //sans-serif / serifを必須にするか。object-fitでエラーださないようにする。
        'at-rule-no-unknown': null, //scssで使える @include などにエラーがでないように
        'scss/at-rule-no-unknown': true, //scssでもサポートしていない @ルールにはエラーを出す
        // 'order/properties-alphabetical-order': true, //ABC順
    }
};
