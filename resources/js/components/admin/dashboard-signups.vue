<script setup>
defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 relative overflow-hidden">
            <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-500 font-medium mb-1">Signups Today</p>
                <span class="text-4xl font-bold text-gray-800 dark:text-white">
                    {{ metrics.activity.users_today }}
                </span>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 p-2 rounded-lg">
                <i class="pi pi-user-plus text-xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>
</template>