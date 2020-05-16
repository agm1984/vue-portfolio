import store from '~/store/index';

/**
 * If the store has the auth token but no user record, this middleware attempts to fetch
 * the user record, and logs out if that fails.
 *
 * @param {Object} to
 * @param {Object} from
 * @param {Function} next
 */
const checkAuth = async (to, from, next) => {
    const isSessionStale = (!store.getters['auth/check'] && store.getters['auth/token']);

    if (isSessionStale) {
        try {
            await store.dispatch('auth/fetchUser');
        } catch (e) {
            store.dispatch('auth/logout');
        }
    }

    return next();
};

export default checkAuth;
