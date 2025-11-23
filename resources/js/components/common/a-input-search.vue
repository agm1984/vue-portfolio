<script setup>
import { watch } from 'vue';
import debounce from 'lodash.debounce';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputText from 'primevue/inputtext';

const TIME_TO_WAIT = 1000; // milliseconds

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
});

const emit = defineEmits([
    'update:model-value',
    'search',
]);

const handleSearch = () => {
    if (props.modelValue.length > 2) {
        emit('search');
    } else if (props.modelValue.length === 0) {
        emit('search');
    }
};

const debouncedSearch = debounce(handleSearch, TIME_TO_WAIT);

watch(() => props.modelValue, (q, prev) => {
    if (q !== prev) debouncedSearch();
});

const handleReset = () => {
    emit('update:model-value', '');
    emit('search');
};

const handleModelValueChanged = (newVal) => {
    emit('update:model-value', newVal.trimStart());
};
</script>

<template>
    <div class="flex">
        <IconField>
            <InputIcon class="pi pi-search" />

            <InputText
                :model-value="modelValue"
                class="w-full"
                placeholder="Search..."
                @update:model-value="handleModelValueChanged"
            />

            <InputIcon
                v-if="modelValue"
                class="pi pi-times cursor-pointer hover:text-primary"
                @click="handleReset"
            />
        </IconField>
    </div>
</template>