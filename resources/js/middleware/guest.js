import store from '~/store/index';

/**
 * Checks if a guest is authenticated,
 * and redirects the user to the home page if so.
 *
 * @param {Object} to
 * @param {Object} from
 * @param {Function} next
 */
const guest = (to, from, next) => {
    if (store.getters['auth/check']) {
        return next({ name: 'home' });
    }

    return next();
};

export default guest;
