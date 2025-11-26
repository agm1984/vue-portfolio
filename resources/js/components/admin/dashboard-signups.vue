<script setup>
defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <a-card class="p-8">
        <div class="flex justify-between items-start">
            <div>
                <h6 class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Signups Today</h6>
                <div class="text-4xl font-semibold text-gray-900 dark:text-white mt-1">
                    {{ metrics.activity.users_today }}
                </div>
            </div>
            <div class="w-12 h-12 flex items-center justify-center bg-green-100 dark:bg-green-900/30 p-2 rounded-full">
                <i class="pi pi-user-plus text-xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </a-card>
</template>
