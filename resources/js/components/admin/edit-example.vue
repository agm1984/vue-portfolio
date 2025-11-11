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
const isEditMode = computed(() => props.mode === 'edit');
const categories = ref([]);
const allTags = ref([]);
const filteredTags = ref([]);
const imagesToRemove = ref([]);

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

const fetchAllCategories = async () => {
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

const fetchAllTags = async () => {
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

        // scalar fields
        ['status', 'category_id', 'name', 'slug', 'summary', 'conclusion'].forEach((field) => {
            payload.append(field, form[field] ?? '');
        });

        // links
        form.links.forEach((link, i) => {
            if (link && typeof link === 'object') {
                Object.keys(link).forEach((field) => {
                payload.append(`links[${i}][${field}]`, link[field]);
                })
            }
        });

        // tags
        form.tags.forEach((tag, i) => {
            if (Object.prototype.toString.call(tag) === '[object String]') {
                payload.append(`tags[${i}]`, tag)
            } else if (tag && typeof tag === 'object') {
                Object.keys(tag).forEach((field) => {
                payload.append(`tags[${i}][${field}]`, tag[field])
                })
            }
        });

        // images
        console.log('form.images', form.images);
        form.images.forEach((image, i) => {
            if (!image.id) payload.append(`images[${i}]`, image); // only include new images
        });

        if (isCreateMode.value) {
            const { data } = await axios.post(route('admin.examples.create'), payload);

            await router.replace({
                name: 'admin.examples.show',
                params: {
                    example: data.example.slug,
                },
            });
        } else {
            payload.append('_method', 'PATCH');

            imagesToRemove.value.forEach((imageId, index) => {
                payload.append(`images_to_remove[${index}]`, imageId);
            });

            const { data } = await axios.post(route('admin.examples.edit', props.initialExample.slug), payload);

            await router.replace({
                name: 'admin.examples.show',
                params: {
                    example: data.example.slug,
                },
            });

            emit('save', data.example);
            imagesToRemove.value = [];
        }

    } catch (err) {
        console.error(`create-example# Problem creating new example: ${err}.`);
    } finally {
        state.value = INITIAL;
    }
};
</script>

<template>
    <form class="w-full grid grid-cols-[100px_1fr] gap-4 mt-8" @submit.prevent="handleSubmit">
        <a-input-field class="mt-2" input-id="edit-example-status" title="Status" required></a-input-field>
        <div>
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
        </div>

        <a-input-field class="mt-2" input-id="edit-example-category-id" title="Category" required></a-input-field>
        <div>
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
        </div>

        <a-input-field class="mt-2" input-id="edit-example-name" title="Name" required></a-input-field>
        <div>
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
        </div>

        <a-input-field class="mt-2" input-id="edit-example-slug" title="Slug" required></a-input-field>
        <div>
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
        </div>

        <a-input-field class="mt-2" input-id="edit-example-summary" title="Summary" required></a-input-field>
        <div>
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
        </div>

        <a-input-field class="mt-2" input-id="edit-example-conclusion" title="Conclusion" required></a-input-field>
        <div>
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
        </div>

        <a-input-field class="mt-2" input-id="edit-example-links" title="Links"></a-input-field>
        <example-links-input
            v-model="v$.links.$model"
            :submitted="submitted"
        />

        <a-input-field class="mt-2" input-id="edit-example-tags" title="Tags"></a-input-field>
        <div>
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
        </div>

        <a-input-field class="mt-2" input-id="edit-example-images" title="Images"></a-input-field>
        <a-multi-image-input
            v-model="v$.images.$model"
            :example-slug="initialExample.slug"
            :existing-images="initialExample.images"
            id="edit-example-images"
            @remove-existing-image="(imageId) => {
                form.images = form.images.filter(image => image.id !== imageId);
                imagesToRemove.push(imageId);
            }"
        />

        <div class="col-span-2 w-full flex items-center justify-end gap-4">
            <Button
                v-if="isEditMode"
                type="button"
                severity="secondary"
                label="Cancel"
                @click="onReset"
            />

            <Button
                type="submit"
                :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-check'"
                label="Save"
                :disabled="isSubmitting"
            />
        </div>
    </form>
</template>
