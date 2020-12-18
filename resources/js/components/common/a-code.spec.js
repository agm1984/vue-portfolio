import { shallowMount } from '@vue/test-utils';
import ACode from '~/components/common/a-code.vue';

describe('a-code.vue', () => {
    it('is unchecked by default', () => {
        const wrapper = shallowMount(ACode);

        expect(wrapper.vm.value).toBeFalsy();
    });
});
