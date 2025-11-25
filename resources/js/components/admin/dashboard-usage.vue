<script setup>
import { computed } from 'vue';
import ProgressBar from 'primevue/progressbar';

const props = defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});

const formattedMemory = computed(() => {
    const bytes = props.metrics.system.memory_usage_b;
    if (!bytes) return '0 MB';
    return (bytes / 1024 / 1024).toFixed(1) + ' MB';
});

const dbQuotaPercentage = computed(() => {
    const size = props.metrics.system.database_size_mb || 0;
    const limit = 50;
    return Math.min((size / limit) * 100, 100);
});
</script>

<template>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col justify-between p-8 transition-colors duration-300">
        <div class="mb-8">
            <div class="flex items-center justify-between text-sm mb-2">
                <h6 class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Memory (RAM)</h6>
                <span class="font-mono font-semibold text-indigo-600 dark:text-indigo-400 transition-colors">{{ formattedMemory }}</span>
            </div>

            <ProgressBar
                :value="Math.min((metrics.system.memory_usage_b / 1024 / 1024 / 512) * 100, 100)"
                :showValue="false"
                class="h-3 rounded-full bg-gray-100 dark:bg-gray-700 transition-colors"
                :pt="{ value: { class: 'bg-indigo-500 rounded-full' } }"
            />
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-right transition-colors">512MB Limit</p>
        </div>

        <div>
            <div class="flex items-center justify-between text-sm mb-2">
                <h6 class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Database Storage</h6>
                <span class="text-purple-600 dark:text-purple-400 font-semibold transition-colors">
                    {{ metrics.system.database_size_mb }} <span class="ml-1 text-xs">MB</span>
                </span>
            </div>

            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-4 overflow-hidden relative transition-colors">
                <div
                    class="h-full bg-linear-to-r from-purple-500 to-indigo-500 transition-all duration-1000"
                    :style="{ width: `${dbQuotaPercentage < 5 ? 5 : dbQuotaPercentage}%` }"
                ></div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-right transition-colors">InnoDB Engine</p>
        </div>

    </div>
</template>
