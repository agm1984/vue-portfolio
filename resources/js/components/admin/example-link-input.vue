<script setup>
import { ref, reactive, watch } from 'vue';
import { required, url, maxLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import InputText from 'primevue/inputtext';

const props = defineProps({
    name: {
        type: String,
        required: false,
        default: '',
    },

    url: {
        type: String,
        required: false,
        default: '',
    },

    submitted: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(['update:name', 'update:url']);

const form = reactive({
    link_name: props.name,
    link_url: props.url,
});

const linkRules = {
    link_name: { required, maxLength: maxLength(255) },
    link_url: { required, url, maxLength: maxLength(255) },
};

const v$ = useVuelidate(linkRules, form);

watch(() => form.link_name, (val) => emit('update:name', val));
watch(() => form.link_url, (val) => emit('update:url', val));
</script>

<template>
    <div>
        <InputText
            v-model="v$.link_name.$model"
            id="example-link-name"
            :class="['w-full', { 'p-invalid': v$.link_name.$invalid && submitted }]"
            autocomplete="off"
            placeholder="Name"
        />

        <a-field-errors
            v-if="v$.link_name.$error && submitted"
            :errors="v$.link_name.$errors"
            name="Name"
        />
    </div>

    <div>
        <InputText
            v-model="v$.link_url.$model"
            id="example-link-url"
            :class="['w-full', { 'p-invalid': v$.link_url.$invalid && submitted }]"
            autocomplete="off"
            placeholder="URL"
        />

        <a-field-errors
            v-if="v$.link_url.$error && submitted"
            :errors="v$.link_url.$errors"
            name="URL"
        />
    </div>
</template>