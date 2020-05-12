import store from '~/store/index';

const guest = (to, from, next) => {
    if (store.getters['auth/check']) {
        return next({ name: 'home' });
    }

    return next();
};

export default guest;
