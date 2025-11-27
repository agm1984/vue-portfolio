<script setup>
import Tag from 'primevue/tag';
import Skeleton from 'primevue/skeleton';

defineProps({
    isLoading: {
        type: Boolean,
        required: true,
    },

    metrics: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <a-card class="p-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <i class="pi pi-cog text-indigo-500 dark:text-indigo-400"></i>
            Environment Specs
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-300 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <i class="pi pi-desktop text-red-500 dark:text-red-400 text-xl"></i>
                    <span class="font-semibold text-gray-700 dark:text-gray-300">Laravel</span>
                </div>

                <Skeleton v-if="isLoading" width="60px" height="24px" />
                <Tag
                    v-else
                    class="px-3"
                    severity="danger"
                    :value="metrics.system?.laravel_version"
                    rounded
                />
            </div>

            <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-300 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <i class="pi pi-code text-blue-500 dark:text-blue-400 text-xl"></i>
                    <span class="font-semibold text-gray-700 dark:text-gray-300">PHP</span>
                </div>

                <Skeleton v-if="isLoading" width="60px" height="24px" />
                <Tag
                    v-else
                    class="px-3"
                    severity="info"
                    :value="metrics.system?.php_version"
                    rounded
                />
            </div>
        </div>
    </a-card>
</template>
