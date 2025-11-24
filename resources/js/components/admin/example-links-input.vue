<script setup>
import { ref, computed, watch } from 'vue';
import Button from 'primevue/button';
import ExampleLinkInput from './example-link-input.vue';

const props = defineProps({
    modelValue: {
        type: Array,
        required: true,
    },

    submitted: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(['update:model-value']);

const hasLinks = computed(() => props.modelValue.length > 0)
const addButtonText = computed(() => (hasLinks.value ? 'Add another' : 'Add'))

const handleRemove = (index) => {
    props.modelValue.splice(index, 1)
    emit('update:model-value', props.modelValue)
}

const handleAddAnother = () => {
    props.modelValue.push({ name: '', url: '' })
    emit('update:model-value', props.modelValue)
}
</script>

<template>
    <div class="w-full flex flex-col gap-4">
        <div
            v-for="(link, i) in modelValue"
            :key="`example-link-${i}`"
            class="w-full grid grid-cols-[200px_1fr_110px] gap-4"
        >
            <example-link-input
                v-model:name="link.name"
                v-model:url="link.url"
                :submitted="submitted"
                @remove="handleRemove(i)"
            />

            <div>
                <Button
                    type="button"
                    severity="danger"
                    icon="pi pi-trash"
                    label="Remove"
                    @click="handleRemove(i)"
                />
            </div>
        </div>

        <div>
            <Button
                type="button"
                severity="secondary"
                icon="pi pi-plus"
                :label="addButtonText"
                @click="handleAddAnother"
            />
        </div>
    </div>
</template>
