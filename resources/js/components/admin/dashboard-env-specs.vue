<script setup>
import Tag from 'primevue/tag';

defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
            <i class="pi pi-cog text-gray-400"></i> Environment Specs
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <i class="pi pi-desktop text-red-500 text-xl"></i>
                    <span class="font-semibold text-gray-700 dark:text-gray-300">Laravel</span>
                </div>
                <Tag
                    class="px-3"
                    severity="danger"
                    :value="metrics.system.laravel_version"
                    rounded
                />
            </div>

            <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <i class="pi pi-code text-blue-500 text-xl"></i>
                    <span class="font-semibold text-gray-700 dark:text-gray-300">PHP</span>
                </div>
                <Tag
                    class="px-3"
                    severity="info"
                    :value="metrics.system.php_version"
                    rounded
                />
            </div>
        </div>
    </div>
</template>
