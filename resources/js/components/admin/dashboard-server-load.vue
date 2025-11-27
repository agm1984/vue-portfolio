<script setup>
import { computed } from 'vue';
import Knob from 'primevue/knob';
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

const getLoadColor = (load) => {
    if (load < 50) return 'green';
    if (load < 80) return 'orange';
    return 'red';
};

const serverLoadPercentage = computed(() => {
    const raw = props.metrics.system?.server_load || 0;

    return Math.min(Math.round(raw), 100);
});

const loadColor = computed(() => getLoadColor(serverLoadPercentage.value));
</script>

<template>
    <a-card class="flex flex-col items-center justify-center text-center p-8">
        <h3 class="mb-4 font-bold text-gray-900 dark:text-white">Server Load</h3>

        <Skeleton v-if="isLoading" width="140px" height="140px" class="mb-4 rounded-full"></Skeleton>

        <Knob
            v-else
            :model-value="serverLoadPercentage"
            :size="140"
            readonly
            value-template="{value}%"
            :value-color="loadColor"
            :text-color="loadColor"
            :stroke-width="8"
        />

        <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
            CPU Load Average (1 min)
        </p>
    </a-card>
</template>
