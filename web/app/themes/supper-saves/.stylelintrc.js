module.exports = {
    extends: ['stylelint-config-recess-order'],
    rules: {
        'block-no-empty': true,
        'color-no-invalid-hex': true,
        'color-hex-case': 'lower',
        'color-named': 'never',
        'unit-no-unknown': true,
        'comment-no-empty': true,
        'max-nesting-depth': [
            5,
            {
                'ignore': ['blockless-at-rules']
            }
        ],
        'color-hex-length': 'short',
        'length-zero-no-unit': true,
        'property-case': 'lower',
        'unit-case': 'lower',
        'declaration-block-single-line-max-declarations': 1,
        'declaration-no-important': true,
        'declaration-colon-space-after': 'always',
        'declaration-colon-space-before': 'never',
        'declaration-block-semicolon-newline-after': 'always-multi-line',
        'declaration-block-trailing-semicolon': 'always',
        'declaration-block-no-redundant-longhand-properties': true,
        'selector-pseudo-element-colon-notation': 'double',
        'block-closing-brace-empty-line-before': 'never',
        'function-comma-space-after': 'always',
        'function-comma-space-before': 'never',
        'number-no-trailing-zeros': true,
        'no-duplicate-selectors': true,
        'no-extra-semicolons': true,
        'no-unknown-animations': true,
        'number-leading-zero': 'always',
        'string-quotes': 'single',
        'selector-combinator-space-after': 'always',
        'selector-combinator-space-before': 'always',
        'selector-list-comma-newline-after': 'always',
        'selector-list-comma-newline-before': 'never-multi-line',
        'selector-list-comma-space-before': 'never',
        'block-opening-brace-space-before': 'always',
        'block-closing-brace-newline-after': [
            'always',
            {
                'ignoreAtRules': [
                    'if',
                    'else'
                ]
            }
        ],
        'max-empty-lines': [
            1,
            {
                'ignore': ['comments']
            }
        ],
        'indentation': 4
    }
};
