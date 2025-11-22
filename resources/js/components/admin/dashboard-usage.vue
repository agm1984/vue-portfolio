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
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex flex-col justify-between">
        <div class="mb-8">
            <div class="flex justify-between text-sm mb-2">
                <span class="text-gray-600 dark:text-gray-300 font-medium">Memory (RAM)</span>
                <span class="font-mono font-bold text-indigo-600">{{ formattedMemory }}</span>
            </div>
            <ProgressBar
                :value="Math.min((metrics.system.memory_usage_b / 1024 / 1024 / 512) * 100, 100)"
                :showValue="false"
                class="h-3 rounded-full bg-gray-100 dark:bg-gray-700"
                :pt="{ value: { class: 'bg-indigo-500 rounded-full' } }"
            />
            <p class="text-xs text-gray-500 mt-2 text-right">512MB Limit</p>
        </div>

        <div>
            <div class="flex justify-between text-sm mb-2 font-medium">
                <span class="text-gray-600 dark:text-gray-300">Database Storage</span>
                <span class="text-purple-600">{{ metrics.system.database_size_mb }} MB</span>
            </div>
            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-4 overflow-hidden relative">
                <div class="h-full bg-linear-to-r from-purple-500 to-indigo-500 transition-all duration-1000"
                        :style="{ width: `${dbQuotaPercentage < 5 ? 5 : dbQuotaPercentage}%` }">
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2 text-right">InnoDB Engine</p>
        </div>
    </div>
</template>
