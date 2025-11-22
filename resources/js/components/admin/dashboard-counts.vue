<script setup>
import { computed } from 'vue';

const props = defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});

const statCards = computed(() => [
    {
        label: 'Total Users',
        value: props.metrics.counts.users,
        icon: 'pi pi-users',
        color: 'text-blue-500',
        bg: 'bg-blue-100'
    },
    {
        label: 'Portfolio Examples',
        value: props.metrics.counts.examples,
        icon: 'pi pi-briefcase',
        color: 'text-purple-500',
        bg: 'bg-purple-100'
    },
    {
        label: 'Categories',
        value: props.metrics.counts.categories,
        icon: 'pi pi-tags',
        color: 'text-emerald-500',
        bg: 'bg-emerald-100'
    },
]);
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
        <a-card
            v-for="stat in statCards"
            :key="`stat-card-${stat.label}`"
            class="flex items-center gap-5 hover:shadow-md transition-shadow duration-300 p-8"
        >
            <div :class="['w-16 h-16 rounded-full flex items-center justify-center', stat.bg, stat.color]">
                <i :class="['', stat.icon]" style="font-size: 24px;"></i>
            </div>
            <div>
                <h6>{{ stat.label }}</h6>

                <p class="text-3xl font-bold text-gray-800 mt-1">{{ stat.value }}</p>
            </div>
        </a-card>
    </div>
</template>