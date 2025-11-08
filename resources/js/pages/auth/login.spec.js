import { createLocalVue, shallowMount } from '@vue/test-utils';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import Buefy from 'buefy';
import route from 'ziggy';
import routes from '~/router/routes';
import Login from './Login.vue';
import ACard from '~/components/common/a-card.vue';

const localVue = createLocalVue();

localVue.use(Vuex);
// localVue.use(VueRouter);
// localVue.use(Buefy, {
//     defaultIconPack: 'fas',
// });

// localVue.mixin({
//     methods: {
//         route,
//     },
// });

// const router = new VueRouter({ routes });

describe('Login.vue', () => {
    it('ignores intendedUrl when it is empty', () => {
        const getters = {
            'auth/intendedUrl': () => '',
        };

        const store = new Vuex.Store({
            getters,
        });

        const $router = {
            replace: jest.fn(),
        };

        const wrapper = shallowMount(Login, {
            components: {
                ACard,
            },
            localVue,
            mocks: {
                $router,
            },
            store,
        });

        expect(wrapper.vm.hasIntendedUrl).toEqual(false);
        expect($router.replace).toHaveBeenCalledTimes(0);
    });

    it('adds intendedUrl redirect to URL when it exists', () => {
        const getters = {
            'auth/intendedUrl': () => 'admin/categories',
        };

        const store = new Vuex.Store({
            getters,
        });

        const $router = {
            replace: jest.fn(),
        };

        const wrapper = shallowMount(Login, {
            components: {
                ACard,
            },
            localVue,
            mocks: {
                $router,
            },
            store,
        });

        expect(wrapper.vm.hasIntendedUrl).toEqual(true);

        expect($router.replace).toHaveBeenCalledWith({
            name: 'login',
            query: { redirect: store.getters['auth/intendedUrl'] },
        });
        expect($router.replace).toHaveBeenCalledTimes(1);
    });

});
