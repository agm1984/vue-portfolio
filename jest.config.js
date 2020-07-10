module.exports = {
    testRegex: 'resources/js/.*.spec.js$',
    moduleFileExtensions: [
        'js',
        'json',
        'vue',
    ],
    transform: {
        '^.+\\.js$': 'babel-jest',
        '^.+\\.vue$': 'vue-jest',
    },
    moduleNameMapper: {
        '^@/(.*)$': '<rootDir>/resources/$1',
        '^~/(.*)$': '<rootDir>/resources/js/$1',
    },
};
