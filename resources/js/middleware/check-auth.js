import store from '~/store/index';

export default async (to, from, next) => {
    if (!store.getters['auth/check'] && store.getters['auth/token']) {
        try {
            await store.dispatch('auth/fetchUser');
            console.log('fetched user after auth check');
        } catch (e) {
            console.log('check-auth# logging out now bye');
            store.dispatch('auth/logout');
        }
    }

    return next();
};
