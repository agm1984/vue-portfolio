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
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex flex-col items-center justify-center text-center">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-6">Server Load</h3>

        <Knob
            v-model="serverLoadPercentage"
            :size="140"
            readonly
            range-color="#f3f4f6"
            value-template="{value}%"
            :value-color="loadColor"
            :stroke-width="8"
        />

        <p class="text-sm text-gray-400 mt-4">CPU Load Average (1 min)</p>
    </div>
</template>
