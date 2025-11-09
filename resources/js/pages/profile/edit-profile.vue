<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { required, email, maxLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import axios from 'axios';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Profile',
});

defineOptions({ name: 'edit-profile' });

const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);

const form = reactive({
    avatar: auth.user.avatar,
    name: auth.user.name,
    email: auth.user.email,
});

const profileRules = {
    avatar: {},
    name: { required, maxLength: maxLength(255) },
    email: { required, email, maxLength: maxLength(255) },
};

const v$ = useVuelidate(profileRules, form);

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

        payload.append('avatar', form.avatar);
        payload.append('name', form.name);
        payload.append('email', form.email);

        const { data } = await axios.post(route('user.profile.edit'), payload);

        console.log('data', data.user);

        auth.updateUser(data);
    } catch (error) {
        console.error(error);
    } finally {
        state.value = INITIAL;
    }
};
</script>

<template>
    <div class="">
        <form @submit.prevent="handleSubmit">
            <div class="flex items-center justify-center">
                <a-single-image-input
                    v-model="form.avatar"
                    :user="auth.user"
                ></a-single-image-input>
            </div>

            <a-input-field input-id="profile-name" title="Name" required />

            <InputText
                v-model="v$.name.$model"
                id="profile-name"
                :class="['w-full', { 'p-invalid': v$.name.$invalid && submitted }]"
                autocomplete="name"
                placeholder=""
            />

            <a-field-errors
                v-if="v$.name.$error && submitted"
                :errors="v$.name.$errors"
                name="Name"
            />

            <a-input-field input-id="profile-email" title="Email" required />

            <InputText
                v-model="v$.email.$model"
                id="profile-email"
                :class="['w-full', { 'p-invalid': v$.email.$invalid && submitted }]"
                autocomplete="email"
                placeholder=""
            />

            <a-field-errors
                v-if="v$.email.$error && submitted"
                :errors="v$.email.$errors"
                name="Email"
            />

            <div class="flex items-center justify-end pt-16">
                <Button
                    type="submit"
                    :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-check'"
                    label="Save"
                    class="mt-8 w-full"
                    :disabled="isSubmitting"
                />
            </div>
        </form>

    </div>
</template>
