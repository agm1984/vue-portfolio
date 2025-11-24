<script setup>
import { useRoute } from 'vue-router';

defineProps({
    item: {
        type: Object,
        required: true,
    },
});

const currentRoute = useRoute();
</script>

<template>
    <router-link
        v-if="item.visible"
        :to="{ name: item.route }"
        class="group flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200"
        :class="[
            currentRoute.name === item.route
                ? 'bg-indigo-50 text-indigo-700'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
        ]"
    >
        <i
            :class="[
                item.icon, 'mr-3 text-lg transition-colors',
                currentRoute.name === item.route ? 'text-indigo-600' : 'text-gray-500 group-hover:text-gray-600',
            ]"
        >
        </i>
        {{ item.label }}
    </router-link>
</template>
