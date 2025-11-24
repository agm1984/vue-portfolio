<script setup>
import Tag from 'primevue/tag';

defineProps({
    label: {
        type: [String, Number],
        required: false,
        default: () => '', // prevents errors while data is populating
    },

    severity: {
        type: String,
        required: false,
        default: () => 'secondary',
    },
});
</script>

<template>
    <div>
        <Tag :severity="severity" :value="label" rounded />
    </div>
</template>
