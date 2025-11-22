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
                <h6>Signups Today</h6>
                <div class="text-4xl font-bold text-gray-800 mt-1">
                    {{ metrics.activity.users_today }}
                </div>
            </div>
            <div class="w-12 h-12 flex items-center justify-center bg-green-100 p-2 rounded-full">
                <i class="pi pi-user-plus text-xl text-green-600"></i>
            </div>
        </div>
    </a-card>
</template>