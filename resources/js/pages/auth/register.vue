<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { required, email, minLength, maxLength, sameAs } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRoute, useRouter } from 'vue-router';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';
import Message from 'primevue/message';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Register',
});

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);

const newPassword = computed(() => form.password);

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const registerRules = {
    name: { required, maxLength: maxLength(255) },
    email: { required, email, maxLength: maxLength(255) },
    password: { required, minLength: minLength(6) },
    password_confirmation: { required, sameAs: sameAs(newPassword) },
};

const v$ = useVuelidate(registerRules, form);

const register = async () => {
    try {
        state.value = SUBMITTING;
        submitted.value = true;

        const isFormValid = await v$.value.$validate();

        if (!isFormValid) {
            state.value = INITIAL;
            return;
        }

        const formData = {
            ...form,
        };

        await auth.register(formData);

        await router.replace({
            name: 'verification.verify',
            query: { email: form.email },
        });
    } catch (error) {
        console.error(error);
    } finally {
        state.value = INITIAL;
    }
};
</script>

<template>
    <div class="flex-1 w-full max-w-3xl mx-auto flex flex-col items-center justify-center p-8">
        <h1>Register</h1>

        <a-card class="w-full flex flex-col p-8 mt-4 self-start">
            <div class="flex flex-col gap-3">
                    <login-with-oauth provider="github"></login-with-oauth>
                    <login-with-oauth provider="twitter"></login-with-oauth>
                </div>

            <div class="flex items-center pt-8">
                <hr class="inline w-full">
                <span class="mx-8">or</span>
                <hr class="inline w-full">
            </div>

            <form class="pt-8" @submit.prevent="register">
                <a-input-field input-id="register-name" title="Name" required />

                <InputText
                    v-model="v$.name.$model"
                    id="register-name"
                    :class="['w-full', { 'p-invalid': v$.name.$invalid && submitted }]"
                    autocomplete="name"
                    placeholder=""
                />

                <a-field-errors
                    v-if="v$.name.$error && submitted"
                    :errors="v$.name.$errors"
                    name="Name"
                />

                <a-input-field class="mt-4" input-id="register-email" title="Email" required />

                <InputText
                    v-model="v$.email.$model"
                    id="register-email"
                    :class="['w-full', { 'p-invalid': v$.email.$invalid && submitted }]"
                    autocomplete="email"
                    placeholder=""
                />

                <a-field-errors
                    v-if="v$.email.$error && submitted"
                    :errors="v$.email.$errors"
                    name="Email"
                />

                <Message class="mt-4" severity="warn"><span class="font-semibold">Note</span>: Your email is private and will not be displayed to anyone except admin users.</Message>

                <a-input-field class="mt-4" input-id="register-password" title="Password" required />

                <Password
                    v-model="v$.password.$model"
                    input-id="register-password"
                    class="w-full"
                    input-class="w-full"
                    placeholder=""
                    autocomplete="current-password"
                    :feedback="false"
                    toggle-mask
                    aria-haspopup="false"
                    :invalid="v$.password.$invalid && submitted"
                />

                <a-field-errors
                    v-if="v$.password.$error && submitted"
                    :errors="v$.password.$errors"
                    name="Password"
                />

                <a-input-field class="mt-4" input-id="register-confirm-password" title="Confirm Password" required />

                <Password
                    v-model="v$.password_confirmation.$model"
                    input-id="register-confirm-password"
                    class="w-full"
                    input-class="w-full"
                    placeholder=""
                    autocomplete="current-password"
                    :feedback="false"
                    toggle-mask
                    aria-haspopup="false"
                    :invalid="v$.password_confirmation.$invalid && submitted"
                />

                <a-field-errors
                    v-if="v$.password_confirmation.$error && submitted"
                    :errors="v$.password_confirmation.$errors"
                    name="Password confirmation"
                />

                <Button
                    type="submit"
                    :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-check'"
                    label="Register"
                    class="w-full mt-4"
                    :disabled="isSubmitting"
                />
            </form>
        </a-card>
    </div>
</template>
