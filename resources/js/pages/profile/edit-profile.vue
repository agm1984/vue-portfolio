<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { required, email, maxLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRouter } from 'vue-router';
import axios from 'axios';
import Message from 'primevue/message';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Profile',
});

const router = useRouter();
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
            state.value = INITIAL;
            return;
        }

        const payload = new FormData();

        payload.append('avatar', form.avatar);
        payload.append('name', form.name);
        payload.append('email', form.email);

        const { data } = await axios.post(route('user.profile.edit'), payload);

        auth.updateUser(data);
    } catch (error) {
        console.error(error);
    } finally {
        state.value = INITIAL;
    }
};

const handleResendVerificationEmail = async () => {
    await router.push({
        name: 'verification.verify',
        query: { email: auth.user.email },
    });
};
</script>

<template>
    <form class="mt-4" @submit.prevent="handleSubmit">
        <Message v-if="!auth.user.email_verified_at" severity="info">
            <span>Your email isn't verified yet.</span>
            <Button
                type="button"
                severity="info"
                class="ml-4"
                label="Resend verification email"
                text
                @click="handleResendVerificationEmail"
            />
        </Message>

        <div class="flex items-center justify-center mt-4">
            <a-single-image-input
                v-model="form.avatar"
                :user="auth.user"
            ></a-single-image-input>
        </div>

        <a-input-field class="mt-4" input-id="profile-name" title="Name" required />

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

        <a-input-field class="mt-4" input-id="profile-email" title="Email" required />

        <div class="flex items-center gap-2">
            <InputText
                v-model="v$.email.$model"
                id="profile-email"
                :class="['w-full', { 'p-invalid': v$.email.$invalid && submitted }]"
                autocomplete="email"
                placeholder=""
                disabled
            />

            <div v-if="auth.user.email_verified_at" class="inline-flex items-center gap-2 rounded-full border border-emerald-500/40 bg-emerald-100 px-3 py-1 text-sm font-medium text-emerald-700 whitespace-nowrap">
                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500 text-white">
                    <i class="pi pi-verified" style="font-size: 12px;"></i>
                </span>
                <span>Verified</span>
            </div>
        </div>

        <a-field-errors
            v-if="v$.email.$error && submitted"
            :errors="v$.email.$errors"
            name="Email"
        />

        <Button
            type="submit"
            class="w-full mt-4"
            :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-check'"
            label="Save"
            :disabled="isSubmitting"
        />
    </form>
</template>
