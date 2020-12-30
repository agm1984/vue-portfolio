import store from '~/store/index';


/**
 * If the store has no user record, this middleware will redirect the
 * user to the login page.
 *
 * @param {Object} to
 * @param {Object} from
 * @param {Function} next
 */
const auth = async (to, from, next) => {
    if (store.getters['auth/check']) {
        return next();
    }

    const intendedUrl = to.fullPath;

    if (intendedUrl.length > 1) {
        store.dispatch('auth/setIntendedUrl', intendedUrl);
    }

    return next({ name: 'login' });
};

export default auth;
