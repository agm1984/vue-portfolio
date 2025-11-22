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
        class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200"
        :class="[
            currentRoute.name === item.route
                ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-200'
        ]"
    >
        <i :class="[item.icon, 'mr-3 text-lg transition-colors',
            currentRoute.name === item.route ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 group-hover:text-gray-600']">
        </i>
        {{ item.label }}
    </router-link>
</template>
