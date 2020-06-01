/**
 * Generates a UUID for default values of components that require DOM element IDs.
 * Adapted from: https://github.com/makeable/uuid-v4.js/blob/master/uuid-v4.js
 *
 * @return {String}
 */
const generateUuid = () => {
    const dec2hex = [];
    let uuid = '';

    for (let i = 0; i <= 15; i += 1) {
        dec2hex[i] = i.toString(16);
    }

    for (let i = 1; i <= 36; i += 1) {
        if (i === 9 || i === 14 || i === 19 || i === 24) {
            uuid += '-';
        } else if (i === 15) {
            uuid += 4;
        } else if (i === 20) {
            uuid += dec2hex[(Math.random() * 4 | 0 + 8)]; // eslint-disable-line no-bitwise
        } else {
            uuid += dec2hex[(Math.random() * 16 | 0)]; // eslint-disable-line no-bitwise
        }
    }

    return uuid;
};

export default generateUuid;
