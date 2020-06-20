import store from '~/store/index';

/**
 * CHECK AUTH:
 *
 * This critical middleware is loaded into `~/router/index.js` as a global middleware,
 * so it runs on every route change, and it runs before any other middleware
 * that would be declared in a component via the Vue instance `middleware` property.
 *
 * The main responsibility of this middleware is to check if the user's session is stale.
 * If it is stale, the Vue app cannot observe the httpOnly session cookie, so it simply
 * tries to fetch the user's profile data because that requires an active session.
 *
 * If that Vuex `auth/fetchUser` action fails, the user will be logged out. Some pages do not
 * require authentication, so this middleware always completes by calling `next()`.
 *
 * If the Vuex `auth/fetchUser` action succeeds, the user's profile data will be rehydrated,
 * and the in-memory auth state will be reset to `IS_LOGGED_IN`.
 *
 * @param {Object} to
 * @param {Object} from
 * @param {Function} next
 * @return {Function}
 * @throws {Function} calls `commit(FETCH_USER_FAILED)` which will trigger the `auth/logout` action.
 */
const checkAuth = async (to, from, next) => {
    console.log('checkAuth@ running');
    if (store.getters['auth/check']) {
        return next();
    }

    try {
        await store.dispatch('auth/fetchUser');
    } catch (e) {} // eslint-disable-line no-empty

    return next();
};

export default checkAuth;
