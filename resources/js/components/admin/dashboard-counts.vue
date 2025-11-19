<script setup>
import { computed } from 'vue';

const props = defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});

const statCards = computed(() => [
    {
        label: 'Total Users',
        value: props.metrics.counts.users,
        icon: 'pi pi-users',
        color: 'text-blue-500',
        bg: 'bg-blue-100 dark:bg-blue-900/30'
    },
    {
        label: 'Portfolio Examples',
        value: props.metrics.counts.examples,
        icon: 'pi pi-briefcase',
        color: 'text-purple-500',
        bg: 'bg-purple-100 dark:bg-purple-900/30'
    },
    {
        label: 'Categories',
        value: props.metrics.counts.categories,
        icon: 'pi pi-tags',
        color: 'text-emerald-500',
        bg: 'bg-emerald-100 dark:bg-emerald-900/30'
    },
]);
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div 
            v-for="stat in statCards"
            :key="stat.label"
            class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-5 hover:shadow-md transition-shadow duration-300"
        >
            <div :class="['p-4 rounded-xl flex items-center justify-center shadow-sm', stat.bg, stat.color]">
                <i :class="['text-2xl', stat.icon]"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">{{ stat.label }}</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ stat.value }}</p>
            </div>
        </div>
    </div>
</template>