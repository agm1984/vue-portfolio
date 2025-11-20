<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { required, email, minLength, maxLength, sameAs } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '~/store/auth';

// PrimeVue Imports
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';

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
    <div class="flex-1 flex items-center justify-center p-8">
        <div class="w-full max-w-md md:max-w-3xl bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="p-8 pb-6 text-center">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="pi pi-user-plus text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Register</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                    Join me for no raisin.
                </p>
            </div>

            <div class="px-8 pb-8">
                <div class="flex flex-col gap-3">
                    <login-with-oauth provider="github"></login-with-oauth>
                    <login-with-oauth provider="twitter"></login-with-oauth>
                </div>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white dark:bg-gray-800 text-gray-500">or</span>
                    </div>
                </div>

                <form @submit.prevent="register" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <a-input-field input-id="register-name" title="Name" required />
                        <IconField iconPosition="left">
                            <InputIcon class="pi pi-id-card text-gray-400" />
                            <InputText
                                v-model="v$.name.$model"
                                id="register-name"
                                :class="['w-full', { 'p-invalid': v$.name.$invalid && submitted }]"
                                autocomplete="name"
                                placeholder=""
                            />
                        </IconField>
                        <a-field-errors
                            v-if="v$.name.$error && submitted"
                            :errors="v$.name.$errors"
                            name="Name"
                        />
                    </div>

                    <div>
                        <a-input-field input-id="register-email" title="Email" required />
                        <IconField iconPosition="left">
                            <InputIcon class="pi pi-envelope text-gray-400" />
                            <InputText
                                v-model="v$.email.$model"
                                id="register-email"
                                :class="['w-full', { 'p-invalid': v$.email.$invalid && submitted }]"
                                autocomplete="email"
                                placeholder=""
                            />
                        </IconField>
                        <a-field-errors
                            v-if="v$.email.$error && submitted"
                            :errors="v$.email.$errors"
                            name="Email"
                        />

                        <div class="mt-2 flex gap-2 items-start text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 p-2 rounded-lg">
                            <i class="pi pi-shield text-indigo-500 mt-0.5"></i>
                            <span>Your email is private and only visible to admins.</span>
                        </div>
                    </div>

                    <div>
                        <a-input-field input-id="register-password" title="Password" required />
                        <div class="relative">
                            <Password
                                v-model="v$.password.$model"
                                input-id="register-password"
                                class="w-full"
                                input-class="w-full"
                                placeholder=""
                                autocomplete="new-password"
                                :feedback="true"
                                toggle-mask
                                :invalid="v$.password.$invalid && submitted"
                            />
                        </div>
                        <a-field-errors
                            v-if="v$.password.$error && submitted"
                            :errors="v$.password.$errors"
                            name="Password"
                        />
                    </div>

                    <div>
                        <a-input-field input-id="register-confirm-password" title="Confirm Password" required />
                        <div class="relative">
                            <Password
                                v-model="v$.password_confirmation.$model"
                                input-id="register-confirm-password"
                                class="w-full"
                                input-class="w-full"
                                placeholder=""
                                autocomplete="new-password"
                                :feedback="false"
                                toggle-mask
                                :invalid="v$.password_confirmation.$invalid && submitted"
                            />
                        </div>
                        <a-field-errors
                            v-if="v$.password_confirmation.$error && submitted"
                            :errors="v$.password_confirmation.$errors"
                            name="Password confirmation"
                        />
                    </div>

                    <Button
                        type="submit"
                        :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-user-plus'"
                        label="Register"
                        class="w-full font-bold mt-4 md:col-span-2"
                        :disabled="isSubmitting"
                    />

                </form>

                <div class="mt-6 text-center text-gray-600 dark:text-gray-400">
                    Already have an account?
                    <router-link :to="{ name: 'login' }" class="font-bold text-indigo-600 hover:underline">
                        Login
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>
