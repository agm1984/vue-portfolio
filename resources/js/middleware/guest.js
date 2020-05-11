import store from '~/store/index';

export default (to, from, next) => {
    if (store.getters['auth/check']) {
        return next({ name: 'home' });
    }

    return next();
};
