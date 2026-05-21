module.exports = {
	// "configBasedir": __dirname, // プロジェクトのルートディレクトリを指す
    extends: [
        '@wordpress/stylelint-config/scss',
        'stylelint-config-recess-order',
    ],
    ignoreFiles: ['./src/js/**/*.js', './**/plugins/*.scss','./assets/**/*.css'],
    rules: {
        // stylelint 16 で core から削除された stylistic ルール（max-line-length /
        // function-url-quotes / number-leading-zero）は設定から除外した。
        'length-zero-no-unit': null,
        'selector-class-pattern': null,
        'no-descending-specificity': null, //セレクタの詳細度に関する警告を出さない
        'at-rule-no-unknown': null, //scssで使える @include などにエラーがでないように
        'scss/at-rule-no-unknown': true, //scssでもサポートしていない @ルールにはエラーを出す
        'font-weight-notation': null, //font-weightの指定は自由
        'font-family-no-missing-generic-family-keyword': null, //[sans-]serif を必須にしない。(object-fitのエラー回避）
        'no-invalid-double-slash-comments': null,

        'scss/load-partial-extension': null, //@import のファイル拡張子(.scss)を許可（旧 at-import-partial-extension）

		'no-invalid-position-at-import-rule': null,

		// 新しくて認識されないプロパティ
		"property-no-unknown": [
			true,
			{
				"ignoreProperties": ["container-name", "container-type"]
			}
		],
		"unit-no-unknown" : [
			true,
			{
				"ignoreUnits": ["cqw"]
			}
		],

        // indentation: 4, //スペースでサイズは4
        // 'length-zero-no-unit': [ true, {ignore: ["custom-properties"]} ],
        // 'string-quotes': 'double', //ダブルクォーテーションに (wordpress でそうなってる)
        // 'no-duplicate-selectors': null, //同じセレクタの出現に関するエラーを出さない
    }
};
