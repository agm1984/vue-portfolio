<script setup>
import { computed } from 'vue';

const props = defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});

const growthRate = computed(() => props.metrics.activity.growth_rate || 0);
const isGrowthPositive = computed(() => growthRate.value >= 0);
</script>

<template>
    <a-card class="p-8">
        <h6>Monthly Growth</h6>

        <div class="flex items-center gap-4 mt-4">
            <span class="text-4xl font-semibold" :class="isGrowthPositive ? 'text-green-500' : 'text-red-500'">
                {{ isGrowthPositive ? '+' : '' }}{{ growthRate }}%
            </span>

            <div class="p-2 rounded-full text-xs font-semibold flex items-center gap-1 uppercase tracking-wide"
                    :class="isGrowthPositive ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                <i :class="['pi', isGrowthPositive ? 'pi-arrow-up' : 'pi-arrow-down']"></i>
            </div>
        </div>
    </a-card>
</template>
