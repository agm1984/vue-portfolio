import store from '~/store/index';

export default (to, from, next) => {
    if (store.getters['auth/user'].role !== 'admin') {
        return next({ name: 'examples' });
    }

    return next();
};
