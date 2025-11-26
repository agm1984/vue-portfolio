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
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Edit Profile',
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
    <form @submit.prevent="handleSubmit" class="flex flex-col gap-6">
        <Message v-if="!auth.user.email_verified_at" severity="info" :closable="false" class="w-full">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <span>Your email isn't verified yet.</span>
                <Button
                    type="button"
                    severity="info"
                    class="p-0 h-auto"
                    label="Resend verification email"
                    text
                    @click="handleResendVerificationEmail"
                />
            </div>
        </Message>

        <a-single-image-input
            v-model="form.avatar"
            :user="auth.user"

        ></a-single-image-input>

        <div>
            <a-input-field input-id="profile-name" title="Name" required />

            <IconField iconPosition="left">
                <InputIcon class="pi pi-user text-gray-500 dark:text-gray-400" />
                <InputText
                    v-model="v$.name.$model"
                    id="profile-name"
                    :class="['w-full', { 'p-invalid': v$.name.$invalid && submitted }]"
                    autocomplete="name"
                    placeholder="Your Name"
                />
            </IconField>

            <a-field-errors
                v-if="v$.name.$error && submitted"
                :errors="v$.name.$errors"
                name="Name"
            />
        </div>

        <div>
            <a-input-field input-id="profile-email" title="Email" required />

            <div class="flex flex-col sm:flex-row gap-2">
                <div class="flex-1">
                    <IconField iconPosition="left">
                        <InputIcon class="pi pi-envelope text-gray-500 dark:text-gray-400" />
                        <InputText
                            v-model="v$.email.$model"
                            id="profile-email"
                            :class="['w-full', { 'p-invalid': v$.email.$invalid && submitted }]"
                            autocomplete="email"
                            placeholder=""
                            disabled
                        />
                    </IconField>
                </div>

                <div v-if="auth.user.email_verified_at" class="h-[42px] inline-flex items-center gap-2 rounded-lg border border-emerald-500/40 bg-emerald-50 dark:bg-emerald-900/20 px-3 py-2 text-sm font-medium text-emerald-700 dark:text-emerald-400 whitespace-nowrap">
                    <i class="pi pi-verified"></i>
                    <span>Verified</span>
                </div>
            </div>

            <a-field-errors
                v-if="v$.email.$error && submitted"
                :errors="v$.email.$errors"
                name="Email"
            />

            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 ml-1">
                Contact support to change your email address.
            </p>
        </div>

        <div class="pt-2">
            <Button
                type="submit"
                class="w-full"
                :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-save'"
                label="Save Changes"
                :disabled="isSubmitting"
            />
        </div>
    </form>
</template>
