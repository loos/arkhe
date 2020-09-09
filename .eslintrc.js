module.exports = {
	extends: [ 'plugin:@wordpress/eslint-plugin/recommended' ],
	// extends: ['wordpress', 'plugin:prettier/recommended'], //eslint:recommended
	// parserOptions: {
	//     sourceType: 'module', //importを使うときに必要
	//     ecmaFeatures: {
	//         experimentalObjectRestSpread: true, //非推奨項目も注意してくれる ??
	//         jsx: true,
	//     },
	// },

	rules: {
		// 'prettier/prettier': 0,
		// indent: [2, 'tab'],
		// quotes: ['error', 'double'],
		// 'space-in-parens': 'error',
		// 'comma-dangle': 'off',
		// 'no-var': 'error', //varを許可しない
		// 'no-console': 'off', //console.logがあってもエラーにしない
		// camelcase: ['warn', { properties: 'never' }], //オブジェクトのキーはキャメルじゃなくてよい

		// jsdoc関連
		'require-jsdoc': 0, //Docコメントなくてもエラーにしない
		'valid-jsdoc': 0, //Docコメントの書き方についてとやかくいわせない
		'jsdoc/require-param': 0, //Docコメントなくてもエラーにしない
		'jsdoc/require-param-type': 0, //Docコメントの書き方についてとやかくいわせない
		'jsdoc/check-access': 0,
		'jsdoc/check-property-names': 0,
		'jsdoc/empty-tags': 0,
		'jsdoc/require-property': 0,
		'jsdoc/require-property-description': 0,
		'jsdoc/require-property-name': 0,
		'jsdoc/require-property-type': 0,
		'jsdoc/check-tag-names': 0,
	},
};
