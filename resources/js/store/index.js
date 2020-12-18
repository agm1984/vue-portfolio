import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import categories from './modules/categories';
import examples from './modules/examples';
import users from './modules/users';

Vue.use(Vuex);

const modules = {
    auth,
    categories,
    examples,
    users,
};

const store = new Vuex.Store({
    modules,
});

export default store;
