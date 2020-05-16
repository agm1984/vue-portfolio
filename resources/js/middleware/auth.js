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
    if (!store.getters['auth/check']) {
        const intendedUrl = to.fullPath;
        return next({ name: 'login', query: { redirect: intendedUrl } });
    }

    return next();
};

export default auth;
