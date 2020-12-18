import { createLocalVue, mount } from '@vue/test-utils';
import Buefy from 'buefy';
import AButton from '~/components/common/a-button.vue';

const localVue = createLocalVue();

localVue.use(Buefy, {
    defaultIconPack: 'fas',
});

let wrapper;

describe('a-button.vue', () => {
    beforeEach(() => {
        wrapper = mount(AButton, {
            localVue,
        });
    });

    it('emits a click event when clicked', () => {
        const button = wrapper.findComponent({ ref: 'button' });

        expect(button.trigger('click'));

        wrapper.vm.$nextTick(() => {
            expect(wrapper.emitted('click')).toBeTruthy();
        });
    });
});
