<script setup>
import { computed } from 'vue';

const props = defineProps({
    size: {
        type: Number,
        default: 32,
    },
    user: {
        type: Object,
        required: true,
    },
});

const size = computed(() => props.size);
const user = computed(() => props.user);

const hasImage = computed(() => !!(user.value?.avatar_url && user.value.avatar_url.length > 0));
const firstLetterOfName = computed(() => (user.value?.name ? user.value.name.charAt(0) : ''));
const containerStyles = computed(() => ['flex items-center justify-center rounded-full bg-gray-200']);
</script>

<template>
    <div
        :class="[containerStyles, {
            'w-8 h-8 min-w-8 min-h-8 max-w-8 max-h-8': size === 32,
            'w-12 h-12 min-w-12 min-h-12 max-w-12 max-h-12': size === 48,
            'w-16 h-16 min-w-16 min-h-16 max-w-16 max-h-16': size === 64,
            'w-32 h-32 min-w-32 min-h-32 max-w-32 max-h-32': size === 128,
            'bg-grey-400 border': !hasImage,
        }]"
    >
        <img
            v-if="hasImage"
            :class="['bg-cover rounded-full', {
                'w-8 h-8 min-w-8 min-h-8 max-w-8 max-h-8': size === 32,
                'w-12 h-12 min-w-12 min-h-12 max-w-12 max-h-12': size === 48,
                'w-16 h-16 min-w-16 min-h-16 max-w-16 max-h-16': size === 64,
                'w-32 h-32 min-w-32 min-h-32 max-w-32 max-h-32': size === 128,
            }]"
            :src="user.avatar_url"
            :alt="`Avatar of ${user.name}`"
            loading="lazy"
        >

        <span
            v-else
            :class="['', {
                'text-sm': size === 32,
                'text-lg': size === 48,
                'text-2xl': size === 64,
                'text-4xl': size === 128,
            }]"
        >{{ firstLetterOfName }}</span>
    </div>
</template>
