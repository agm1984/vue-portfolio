<script setup>
import { computed } from 'vue';
import Skeleton from 'primevue/skeleton';

const props = defineProps({
    isLoading: {
        type: Boolean,
        required: true,
    },

    metrics: {
        type: Object,
        required: true,
    },
});

const statCards = computed(() => [
    {
        label: 'Total Users',
        value: props.metrics.counts?.users,
        icon: 'pi pi-users',
        color: 'text-blue-500 dark:text-blue-400',
        bg: 'bg-blue-100 dark:bg-blue-900/30'
    },
    {
        label: 'Portfolio Examples',
        value: props.metrics.counts?.examples,
        icon: 'pi pi-briefcase',
        color: 'text-purple-500 dark:text-purple-400',
        bg: 'bg-purple-100 dark:bg-purple-900/30'
    },
    {
        label: 'Categories',
        value: props.metrics.counts?.categories,
        icon: 'pi pi-tags',
        color: 'text-emerald-500 dark:text-emerald-400',
        bg: 'bg-emerald-100 dark:bg-emerald-900/30'
    },
]);
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
        <a-card
            v-for="stat in statCards"
            :key="`stat-card-${stat.label}`"
            class="p-8 flex items-center gap-4"
        >
            <div :class="['w-16 h-16 rounded-full flex items-center justify-center', stat.bg, stat.color]">
                <i :class="['', stat.icon]" style="font-size: 24px;"></i>
            </div>

            <div class="ml-4">
                <h6 class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                    {{ stat.label }}
                </h6>

                <Skeleton v-if="props.isLoading" class="mt-1" width="60%" height="2rem"></Skeleton>
                <p v-else class="text-3xl font-semibold text-gray-900 dark:text-white mt-1">
                    {{ stat.value }}
                </p>
            </div>
        </a-card>
    </div>
</template>
