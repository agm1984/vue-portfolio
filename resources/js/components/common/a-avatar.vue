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
            'w-16 h-16 min-w-16 min-h-16 max-w-16 max-h-16': size === 64,
            'bg-grey-400 border': !hasImage,
        }]"
    >
        <img
            v-if="hasImage"
            :class="['bg-cover rounded-full', {
                'w-8 h-8 min-w-8 min-h-8 max-w-8 max-h-8': size === 32,
                'w-16 h-16 min-w-16 min-h-16 max-w-16 max-h-16': size === 64,
            }]"
            :src="user.avatar_url"
            :alt="`Avatar of ${user.name}`"
        >

        <span v-else>{{ firstLetterOfName }}</span>
    </div>
</template>
