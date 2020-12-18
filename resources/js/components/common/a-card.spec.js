import { shallowMount } from '@vue/test-utils';
import ACard from '~/components/common/a-card.vue';

describe('a-card.vue', () => {
    it('can generate a UUID for sacred geometry', () => {
        const wrapper = shallowMount(ACard, {
            propsData: {
                id: undefined,
            },
            stubs: ['a-sacred-geometry'],
        });

        expect(typeof wrapper.vm.id).toEqual('string');
        expect(wrapper.vm.id.length).toEqual(36);
    });
});
