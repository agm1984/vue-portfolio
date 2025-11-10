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

function handleRemove(index) {
  props.modelValue.splice(index, 1)
  emit('update:model-value', props.modelValue)
}

function handleAddAnother() {
  props.modelValue.push({ name: '', url: '' })
  emit('update:model-value', props.modelValue)
}
</script>

<template>
    <div class="flex flex-col w-full h-auto">
        <div v-for="(link, i) in modelValue" :key="`example-link-${i}`">
            <example-link-input
                v-model:name="link.name"
                v-model:url="link.url"
                :submitted="submitted"
                @remove="handleRemove(i)"
            />

            <Button
                type="button"
                label="Remove"
                @click="handleRemove(i)"
            />
        </div>

        <div class="flex items-center justify-end">
            <Button
                type="button"
                :label="addButtonText"
                @click="handleAddAnother"
            />
        </div>
  </div>
</template>
