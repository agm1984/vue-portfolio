import store from '~/store/index';

const auth = async (to, from, next) => {
    if (!store.getters['auth/check']) {
        return next({ name: 'login' });
    }

    return next();
};

export default auth;
