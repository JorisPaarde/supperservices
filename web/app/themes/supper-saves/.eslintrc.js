module.exports = {
    root: true,
    env: {
        node: true,
    },
    extends: [
        'airbnb-base',
        'airbnb-typescript/base',
        'plugin:@typescript-eslint/recommended',
        'plugin:@typescript-eslint/recommended-requiring-type-checking',
        'plugin:vue/vue3-recommended',
        'plugin:prettier-vue/recommended',
        'prettier',
    ],
    plugins: ['vue', '@typescript-eslint', 'prettier-vue'],
    rules: {
        indent: [
            'error',
            4,
            {
                SwitchCase: 1,
            },
        ],
        'vue/block-lang': [
            'error',
            {
                script: {
                    lang: 'ts',
                },
            },
        ],
        'no-console': 0,
        'vue/no-v-html': 0,
    },
    settings: {
        'import/resolver': {
            typescript: {},
        },
    },
    parser: 'vue-eslint-parser',
    parserOptions: {
        parser: '@typescript-eslint/parser',
        extraFileExtensions: ['.vue'],
        project: ['../../../../tsconfig.json'],
        tsconfigRootDir: __dirname,
    },
};
