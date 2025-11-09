
<script setup>
import { ref, reactive, computed, watch } from 'vue';
import { useVuelidate } from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import axios from 'axios';
import Select from 'primevue/select';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { Category } from '~/globalModelTypes';

const props = defineProps({
  category: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['reset', 'submit'])

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);

const form = reactive({
    status: props.category.status,
    slug: props.category.slug,
    name: props.category.name,
});

const editCategoryRules = {
    status: { required },
    slug: { required },
    name: { required },
};

const v$ = useVuelidate(editCategoryRules, form);

const clone = (obj) => (obj ? JSON.parse(JSON.stringify(obj)) : {})

// Local editable copy to avoid mutating the prop directly
const modifiedCategory = ref(clone(props.category))

// Keep local copy in sync if parent prop changes
watch(
  () => props.category,
  (val) => {
    form = clone(val)
  },
  { deep: true }
)

const statuses = computed(() => [
  { status: Category.STATUS_INACTIVE, label: 'Inactive' },
  { status: Category.STATUS_ACTIVE, label: 'Active' },
])

function onReset() {
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

        const { data } =await axios.patch(route('admin.categories.edit', { category: props.category.slug }), form);
        emit('save', data.category);
    } catch (error) {
        console.error(error);
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
      </a-input-row>

      <a-input-row class="pt-16" type="is-wider-right" heading="Slug">
        <!-- <a-text-input v-model="modifiedCategory.slug" vid="slug" rules="required" /> -->
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
      </a-input-row>

      <a-input-row class="pt-16" type="is-wider-right" heading="Name">
        <!-- <a-text-input v-model="modifiedCategory.name" vid="name" rules="required" /> -->
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
      </a-input-row>

      <div class="flex items-center justify-end gap-4 pt-16">
        <Button type="button" outlined @click="onReset">
          Cancel
        </Button>

        <Button type="submit" :loading="isSubmitting">
          Save
        </Button>
      </div>
    </form>
  </div>
</template>
