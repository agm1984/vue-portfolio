/**
 * Jest occasionally throws "Jest encountered an unexpected token" error messages.
 * At the time of this writing, the cause is typically external libraries that use ESM syntax imports/exports,
 * and the solution is typically to add offending modules here to the `esModules` list.
 *
 * Each element represents the NPM package name as seen in `package.json`.
 */
const esModules = [
    'prism-es6',
    'prismjs',
    '@vue/test-utils',
].join('|');

module.exports = {
    testRegex: 'resources/js/.*.spec.js$',
    moduleFileExtensions: [
        'js',
        'json',
        'vue',
    ],
    transform: {
        '^.+\\.(js|jsx)?$': '<rootDir>/node_modules/babel-jest',
        '^.+\\.vue$': 'vue-jest',
    },
    transformIgnorePatterns: [`/node_modules/(?!${esModules})`],

    /**
     * This helps map import locations to pseudo-directories and also helps with stubbing. It is likely that
     * all Webpack aliases as seen in `./webpack.mix.js` will be added here too. For optimal linting,
     * please consider the `import/resolver` setting in `./eslintrc.json`. Notice how all three of these locations
     * contain positively-correlated definitions.
     */
    moduleNameMapper: {
        '^@/(.*)$': '<rootDir>/resources/$1',
        '^~/(.*)$': '<rootDir>/resources/js/$1',
        '^ziggy$': '<rootDir>/vendor/tightenco/ziggy/dist/js/route.js',
        '\\.(css|scss)$': '<rootDir>/__mocks__/styleMock.js', // all CSS files are stubbed--some are imported from `node_modules`
    },
};
