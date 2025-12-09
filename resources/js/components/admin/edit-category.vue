
<script setup>
import { ref, reactive, computed, watch } from 'vue';
import { useVuelidate } from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import { useRouter } from 'vue-router';
import Select from 'primevue/select';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { Category } from '~/globalModelTypes';
import { api } from '~/services/api';

const props = defineProps({
    mode: {
        type: String,
        required: true,
    },

    initialCategory: {
        type: Object,
        required: false,
        default: () => ({
            status: Category.STATUS_ACTIVE,
            slug: '',
            name: '',
        }),
    },
})

const emit = defineEmits(['reset', 'save']);

const router = useRouter();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);
const isCreateMode = computed(() => props.mode === 'create');
const isEditMode = computed(() => props.mode === 'edit');

const form = reactive({
    status: props.initialCategory.status,
    slug: props.initialCategory.slug,
    name: props.initialCategory.name,
});

const editCategoryRules = {
    status: { required },
    slug: { required },
    name: { required },
};

const v$ = useVuelidate(editCategoryRules, form);

watch(() => props.initialCategory.status, () => { form.status = props.initialCategory.status });
watch(() => props.initialCategory.slug, () => { form.slug = props.initialCategory.slug });
watch(() => props.initialCategory.name, () => { form.name = props.initialCategory.name });

const statuses = computed(() => [
    { status: Category.STATUS_INACTIVE, label: 'Inactive' },
    { status: Category.STATUS_ACTIVE, label: 'Active' },
])

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

        if (isCreateMode.value) {
            const { data } = await api.post(route('admin.categories.create'), form);

            await router.replace({
                name: 'admin.categories.show',
                params: { category: data.category.slug },
            });
        } else {
            const { data } = await api.patch(route('admin.categories.edit', { category: props.initialCategory.slug }), form);

            await router.replace({
                name: 'admin.categories.show',
                params: { category: data.category.slug },
            });

            emit('save', data.category);
        }
    } catch (error) {
        console.error(error);
    } finally {
        state.value = INITIAL;
    }
};
</script>

<template>
    <form class="w-full grid grid-cols-[100px_1fr] gap-4 mt-4" @submit.prevent="handleSubmit">
        <a-input-field class="mt-2" input-id="edit-category-status" title="Status" required></a-input-field>
        <div>
            <Select
                v-model="v$.status.$model"
                id="edit-category-status"
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

        <a-input-field class="mt-2" input-id="edit-category-slug" title="Slug" required></a-input-field>
        <div>
            <InputText
                v-model="v$.slug.$model"
                id="edit-category-slug"
                :class="['w-full', { 'p-invalid': v$.slug.$invalid && submitted }]"
                autocomplete="off"
            />

            <a-field-errors
                v-if="v$.slug.$error && submitted"
                :errors="v$.slug.$errors"
                name="Slug"
            />
        </div>

        <a-input-field class="mt-2" input-id="edit-category-name" title="Name" required></a-input-field>
        <div>
            <InputText
                v-model="v$.name.$model"
                id="edit-category-name"
                :class="['w-full', { 'p-invalid': v$.name.$invalid && submitted }]"
                autocomplete="off"
                placeholder=""
            />

            <a-field-errors
                v-if="v$.name.$error && submitted"
                :errors="v$.name.$errors"
                name="Name"
            />
        </div>

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
