<script setup>
import Button from 'primevue/button';

defineProps({
    title: {
        type: String,
        required: true,
    },

    description: {
        type: String,
        required: false,
        default: '',
    },

    hasBack: {
        type: Boolean,
        required: false,
        default: () => false,
    },

    centered: {
        type: Boolean,
        required: false,
        default: () => false,
    },
});

const emit = defineEmits([
    'on-back',
]);

const onBack = () => {
    emit('on-back');
};
</script>

<template>
    <div
        :class="['flex items-center justify-center gap-4 mb-4', {
            'md:justify-start': !centered,
        }]"
    >
        <div v-if="hasBack" class="min-w-10 min-h-10">
            <Button
                v-tooltip.bottom="'Go Back'"
                type="button"
                severity="secondary"
                icon="pi pi-arrow-left"
                aria-label="Go Back"
                outlined
                rounded
                @click="onBack"
            />
        </div>

        <div
            :class="['flex flex-col items-center gap-2 text-center', {
                'md:items-start md:text-left': !centered,
            }]"
        >
            <h1>{{ title }}</h1>

            <p v-if="description" class="text-gray-600 dark:text-gray-400">{{ description }}</p>
            <slot v-else name="description"></slot>
        </div>
    </div>
</template>