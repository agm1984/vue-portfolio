<script setup>
import { computed } from 'vue';
import Knob from 'primevue/knob';

const props = defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});

const getLoadColor = (load) => {
    if (load < 50) return 'var(--green-500)';
    if (load < 80) return 'var(--orange-500)';
    return 'var(--red-500)';
};

const serverLoadPercentage = computed(() => {
    const raw = props.metrics.system.server_load || 0;
    return Math.min(Math.round(raw / 100 * 100), 100);
});

const loadColor = computed(() => getLoadColor(serverLoadPercentage.value));
</script>

<template>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col items-center justify-center text-center p-8 transition-colors duration-300">
        <h3 class="mb-4 font-bold text-gray-900 dark:text-white">Server Load</h3>

        <Knob
            v-model="serverLoadPercentage"
            :size="140"
            readonly
            value-template="{value}%"
            :value-color="loadColor"
            :stroke-width="8"
        />

        <p class="text-sm text-gray-500 dark:text-gray-400 mt-4 transition-colors">
            CPU Load Average (1 min)
        </p>
    </div>
</template>
