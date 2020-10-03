import { createLocalVue, shallowMount } from '@vue/test-utils';
import VueMeta from 'vue-meta';
import App from './App.vue';

let localVue = createLocalVue();
localVue.use(VueMeta);

let wrapper;

describe('App.vue', () => {
    beforeEach(() => {
        wrapper = shallowMount(App, {
            localVue,

        });
    });

    it('it should handle page titles', () => {
        expect(wrapper.vm.$meta().refresh().metaInfo.title).toBe("Adam Mackintosh's Portfolio");
    });

    // it('it should set page layouts', () => {
    //     const wrapper = shallowMount(App);
    //     const data = App.data();

    //     expect(data.layout).toBe(null);

    //     wrapper.vm.setLayout('basic');

    //     console.log('casd', App.data());
    // });
    // it('sets layout', () => {
    //     const setLayout = jest.spyOn(wrapper.vm, 'setLayout');

    //     wrapper.vm.setLayout('basic');

    //     expect(setLayout).toHaveBeenCalledWith('basic');
    // });
});
