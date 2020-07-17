module.exports = {
    env: {
        // browser: true,
        // node: true,
        // commonjs: true,
        // es6: true,
        // jquery: true,
    },
    extends: ['wordpress', 'plugin:prettier/recommended'], //eslint:recommended
    plugins: ['react'],
    parser: 'babel-eslint', //JSXとかでエラー出るのを回避
    parserOptions: {
        // ecmaVersion: 2018,
        sourceType: 'module', //importを使うときに必要
        ecmaFeatures: {
            experimentalObjectRestSpread: true, //非推奨項目も注意してくれる ??
            jsx: true,
        },
    },

    rules: {
        // 'prettier/prettier': 0,
        // indent: [2, 4],
        // quotes: ['error', 'double'],
        // 'space-in-parens': 'error',
        // 'comma-dangle': 'off',
        'no-var': 'error', //varを許可しない
        'no-console': 'off', //console.logがあってもエラーにしない
        'require-jsdoc': 'off', //Docコメントなくてもエラーにしない
        'valid-jsdoc': 'off', //Docコメントの書き方についてとやかくいわせない
        camelcase: ['warn', { properties: 'never' }], //オブジェクトのキーはキャメルじゃなくてよい
        // 'space-infix-ops': 0,
        // 'space-in-parens': 0,
        // 'react-in-jsx-scope': 'off',
        // 'react/no-set-state': 'error', //react/no-set-stateルールを適用
        'react/jsx-uses-vars': 1, //これを使うとJSXで使ってる変数がno-useとして認識されるのを防げた
    },
};
