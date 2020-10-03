import { createLocalVue, mount, shallowMount } from '@vue/test-utils';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import Buefy from 'buefy';
import route from 'ziggy';
import routes from '~/router/routes';
import LoginForm from './login-form.vue';
import AForm from '~/components/common/a-form.vue';
import ATextInput from '~/components/common/a-text-input.vue';
import ACheckbox from '~/components/common/a-checkbox.vue';
import AButton from '~/components/common/a-button.vue';
import generateVueRoot from '~/test/stubs';

describe('login-form.vue', () => {
    let wrapper;

    let loginButton;

    beforeEach(() => {
        const localVue = createLocalVue();

        localVue.use(Vuex);

        const getters = {
            'auth/intendedUrl': () => '',
        };

        const store = new Vuex.Store({
            getters,
        });

        localVue.use(Buefy, {
            defaultIconPack: 'fas',
        });

        localVue.use(VueRouter);

        const router = new VueRouter({ routes });

        loginButton = jest.fn();

        wrapper = mount(LoginForm, {
            components: {
                AForm,
                ATextInput,
                ACheckbox,
                AButton,
            },
            localVue,
            store,
            router,
            mocks: {
                login: loginButton,
            },
        });
    });

    it('has the correct initial state', () => {
        expect(wrapper.vm.$data.state).toEqual('INITIAL');

        expect(wrapper.vm.$data.credentials.email).toEqual('');
        expect(wrapper.vm.$data.credentials.password).toEqual('');
        expect(wrapper.vm.$data.credentials.remember).toEqual(true);
    });

    // it('can login with test credentials', () => {
    //     const credentials = {
    //         email: 'test@example.com',
    //         password: 'password',
    //         remember: true,
    //     };

    //     wrapper.setData({ credentials });

    //     expect(wrapper.vm.credentials).toEqual(credentials);

    //     const button = wrapper.find('button');
    //     button.trigger('click');

    //     wrapper.vm.$nextTick(() => {
    //         expect(wrapper.vm.$data.state).toEqual('AUTHENTICATING');

    //         expect(loginButton).toHaveBeenCalledTimes(1);
    //     });
    // });
});
