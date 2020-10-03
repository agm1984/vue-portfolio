import { shallowMount } from '@vue/test-utils';
import ACheckbox from '~/components/common/a-checkbox.vue';

describe('a-checkbox.vue', () => {
    it('is unchecked by default', () => {
        const wrapper = shallowMount(ACheckbox);

        expect(wrapper.vm.value).toBeFalsy();
    });
});
