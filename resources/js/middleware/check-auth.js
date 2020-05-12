import store from '~/store/index';

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
