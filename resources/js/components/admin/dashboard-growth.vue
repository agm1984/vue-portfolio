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

const growthRate = computed(() => props.metrics.activity?.growth_rate || 0);
const isGrowthPositive = computed(() => growthRate.value >= 0);
</script>

<template>
    <a-card class="p-8">
        <h6 class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Monthly Growth</h6>

        <Skeleton v-if="isLoading" class="mt-4" width="40%" height="2rem"></Skeleton>

        <div v-else class="flex items-center gap-4 mt-4">
            <span
                class="text-4xl font-semibold"
                :class="isGrowthPositive ? 'text-green-500 dark:text-green-400' : 'text-red-500 dark:text-red-400'"
            >
                {{ isGrowthPositive ? '+' : '' }}{{ growthRate }}%
            </span>

            <div
                class="p-2 rounded-full text-xs font-semibold flex items-center gap-1 uppercase tracking-wide"
                :class="isGrowthPositive ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'"
            >
                <i :class="['pi', isGrowthPositive ? 'pi-arrow-up' : 'pi-arrow-down']"></i>
            </div>
        </div>
    </a-card>
</template>
