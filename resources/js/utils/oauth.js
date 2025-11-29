/**
 * Load the OAuth window.
 *
 * @param {String} url
 * @param {String} title
 * @param {Object} options
 * @return {Window}
 */
export const openWindow = (url, title, options = {}) => {
    if (typeof url === 'object') {
        options = url;
        url = '';
    }

    const dualScreenLeft = (window.screenLeft !== undefined) ? window.screenLeft : window.screen.left;
    const dualScreenTop = (window.screenTop !== undefined) ? window.screenTop : window.screen.top;
    const width = (window.innerWidth || document.documentElement.clientWidth || window.screen.width);
    const height = (window.innerHeight || document.documentElement.clientHeight || window.screen.height);

    options = { url, title, width: 600, height: 720, ...options };
    options.left = (((width / 2) - (options.width / 2)) + dualScreenLeft);
    options.top = (((height / 2) - (options.height / 2)) + dualScreenTop);

    const optionsStr = Object.keys(options).reduce((acc, key) => {
        acc.push(`${key}=${options[key]}`);
        return acc;
    }, []).join(',');

    const newWindow = window.open(url, title, optionsStr);

    if (window.focus) {
        newWindow.focus();
    }

    return newWindow;
};
