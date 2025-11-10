<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { required } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRouter } from 'vue-router';
import Select from 'primevue/select';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Autocomplete from 'primevue/autocomplete';
import Button from 'primevue/button';
import axios from 'axios';
import ExampleLinksInput from './example-links-input.vue';
import { Example } from '~/globalModelTypes';
import { escapeRegExpChars } from '~/utils/formatting';

const props = defineProps({
    mode: {
        type: String,
        required: true,
    },

    initialExample: {
        type: Object,
        required: false,
        default: () => ({
            status: Example.STATUS_ACTIVE,
            category_id: undefined,
            name: '',
            slug: '',
            summary: '',
            conclusion: '',
            links: [],
            tags: [],
            images: [],
        }),
    },
});

const emit = defineEmits(['reset', 'save']);

const router = useRouter();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);
const isCreateMode = computed(() => props.mode === 'create');
// const isEditMode = computed(() => props.mode === 'edit');
const categories = ref([]);
const allTags = ref([]);
const filteredTags = ref([]);

const form = reactive({
    status: props.initialExample.status,
    category_id: props.initialExample.category_id,
    name: props.initialExample.name,
    slug: props.initialExample.slug,
    summary: props.initialExample.summary,
    conclusion: props.initialExample.conclusion,
    links: props.initialExample.links,
    tags: props.initialExample.tags,
    images: props.initialExample.images,
});

const editExampleRules = {
    status: { required },
    category_id: { required },
    name: { required },
    slug: { required },
    summary: { required },
    conclusion: { required },
    links: {},
    tags: {},
    images: {},
};

const v$ = useVuelidate(editExampleRules, form);

const statuses = computed(() => ([
  { status: Example.STATUS_INACTIVE, label: 'Inactive' },
  { status: Example.STATUS_ACTIVE, label: 'Active' },
]));

async function fetchAllCategories() {
  try {
    const { data } = await axios.get(route('admin.categories.getAll'))
    categories.value = data.categories || []
    // Default to first category if available
    if (!form.category_id && categories.value.length) {
      form.category_id = categories.value[0].id
    }
  } catch (err) {
    console.error(`create-example# Problem fetching all active categories: ${err}.`)
  }
}

onMounted(fetchAllCategories);

async function fetchAllTags() {
    try {
        const { data } = await axios.get(route('admin.tags.getAll'));
        allTags.value = data.tags || [];
    } catch (err) {
        console.error(`create-example# Problem fetching all tags: ${err}.`);
    }
}

onMounted(fetchAllTags);

const handleTagMatches = (event) => {
    const matches = allTags.value
        .map(tag => tag.name)
        .filter(tagName => new RegExp(escapeRegExpChars(event.query), 'i').test(tagName));

    filteredTags.value = matches;
};

const onReset = () => {
    emit('reset')
}

const handleSubmit = async () => {
  try {
        state.value = SUBMITTING;
        submitted.value = true;

        const isFormValid = await v$.value.$validate();

        if (!isFormValid) {
            console.log('Form is invalid');
            state.value = INITIAL;
            return;
        }

        const payload = new FormData();

        // Append simple scalar fields
        ['status', 'category_id', 'name', 'slug', 'summary', 'conclusion'].forEach((field) => {
        payload.append(field, form[field] ?? '');
        });

        // Append links
        form.links.forEach((link, i) => {
        if (link && typeof link === 'object') {
            Object.keys(link).forEach((field) => {
            payload.append(`links[${i}][${field}]`, link[field]);
            })
        }
        });

        // Append tags (supports both strings and objects)
        form.tags.forEach((tag, i) => {
        if (Object.prototype.toString.call(tag) === '[object String]') {
            payload.append(`tags[${i}]`, tag)
        } else if (tag && typeof tag === 'object') {
            Object.keys(tag).forEach((field) => {
            payload.append(`tags[${i}][${field}]`, tag[field])
            })
        }
        });

        // Append images (files)
        form.images.forEach((image, i) => payload.append(`images[${i}]`, image));

        if (isCreateMode.value) {
            const { data } = await axios.post(route('admin.examples.create'), payload);

            await router.replace({
                name: 'admin.examples.show',
                params: {
                    example: data.example.slug,
                },
            });
        } else {
            const { data } = await axios.patch(route('admin.examples.edit', props.initialExample.slug), form);

            await router.replace({
                name: 'admin.examples.show',
                params: {
                    example: data.example.slug,
                },
            });

            emit('save', data.example);
        }

    } catch (err) {
        console.error(`create-example# Problem creating new example: ${err}.`);
    } finally {
        state.value = INITIAL;
    }
};
</script>

<template>
    <div class="relative">
        <form @submit.prevent="handleSubmit">
            <a-input-row type="is-wider-right" heading="Status">
                <Select
                    v-model="v$.status.$model"
                    id="edit-example-status"
                    :options="statuses"
                    option-value="status"
                    option-label="label"
                    :invalid="v$.status.$error && submitted"
                />

                <a-field-errors
                    v-if="v$.status.$error && submitted"
                    :errors="v$.status.$errors"
                    name="Status"
                />
            </a-input-row>

            <a-input-row class="pt-4" type="is-wider-right" heading="Category">
                <Select
                    v-model="v$.category_id.$model"
                    id="edit-example-category-id"
                    :options="categories"
                    option-value="id"
                    option-label="name"
                    :invalid="v$.category_id.$error && submitted"
                />

                <a-field-errors
                    v-if="v$.category_id.$error && submitted"
                    :errors="v$.category_id.$errors"
                    name="Category"
                />
            </a-input-row>

            <a-input-row class="pt-4" type="is-wider-right" heading="Name">
                <InputText
                    v-model="v$.name.$model"
                    id="edit-example-name"
                    :class="['w-full', { 'p-invalid': v$.name.$invalid && submitted }]"
                    autocomplete="off"
                />

                <a-field-errors
                    v-if="v$.name.$error && submitted"
                    :errors="v$.name.$errors"
                    name="Name"
                />
            </a-input-row>

            <a-input-row class="pt-4" type="is-wider-right" heading="Slug">
                <InputText
                    v-model="v$.slug.$model"
                    id="edit-example-slug"
                    :class="['w-full', { 'p-invalid': v$.slug.$invalid && submitted }]"
                    autocomplete="off"
                />

                <a-field-errors
                    v-if="v$.slug.$error && submitted"
                    :errors="v$.slug.$errors"
                    name="Slug"
                />
            </a-input-row>

            <a-input-row class="pt-4" type="is-wider-right" heading="Summary" is-tall>
                <Textarea
                    v-model="v$.summary.$model"
                    id="edit-example-summary"
                    :class="['w-full', { 'p-invalid': v$.summary.$invalid && submitted }]"
                    rows="6"
                    autocomplete="off"
                    maxlength="2000"
                />

                <a-field-errors
                    v-if="v$.summary.$error && submitted"
                    :errors="v$.summary.$errors"
                    name="Summary"
                />
            </a-input-row>

            <a-input-row class="pt-4" type="is-wider-right" heading="Conclusion" is-tall>
                <Textarea
                    v-model="v$.conclusion.$model"
                    id="edit-example-conclusion"
                    :class="['w-full', { 'p-invalid': v$.conclusion.$invalid && submitted }]"
                    rows="6"
                    autocomplete="off"
                    maxlength="2000"
                />

                <a-field-errors
                    v-if="v$.conclusion.$error && submitted"
                    :errors="v$.conclusion.$errors"
                    name="Conclusion"
                />
            </a-input-row>

            <a-input-row class="pt-4" type="is-wider-right" heading="Links" is-tall>
                <example-links-input
                    v-model="v$.links.$model"
                    :submitted="submitted"
                />
            </a-input-row>

            <a-input-row class="pt-4" type="is-wider-right" heading="Tags" is-tall>
                <Autocomplete
                    v-model="v$.tags.$model"
                    input-id="edit-example-tags"
                    class="w-full"
                    :invalid="v$.tags.$error && submitted"
                    :suggestions="filteredTags"
                    placeholder="Type a tag..."
                    multiple
                    @complete="handleTagMatches"
                />

                <a-field-errors
                    v-if="v$.tags.$error && submitted"
                    :errors="v$.tags.$errors"
                    name="Tags"
                />
            </a-input-row>

            <a-input-row class="pt-4" type="is-wider-right" heading="Images">
                <a-multi-image-input
                    v-model="v$.images.$model"
                    id="edit-example-images"
                />
            </a-input-row>

            <div class="flex items-center justify-end gap-4">
                <Button
                    type="button"
                    severity="secondary"
                    label="Cancel"
                    @click="onReset"
                />

                <Button
                    type="submit"
                    icon="pi pi-check"
                    label="Save"
                    :disabled="isSubmitting"
                />
            </div>
        </form>
    </div>
</template>
