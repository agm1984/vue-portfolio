<script setup>
defineProps({
    inputId: {
        type: String,
        required: false,
        default: () => '',
    },

    title: {
        type: String,
        required: true,
    },

    disabled: {
        type: Boolean,
        required: false,
        default: () => false,
    },

    required: {
        type: Boolean,
        required: false,
        default: () => false,
    },
});
</script>

<template>
    <div class="flex gap-1">
        <label
            :for="inputId"
            :class="['font-semibold text-grey-900', {
                'opacity-50': disabled,
            }]"
        >{{ title }}</label>

        <span v-if="required" aria-hidden="true" class="text-red-700">*</span>

        <!-- <UIHelp v-if="$slots.help">
            <slot name="help"></slot>
        </UIHelp> -->
    </div>
</template>
