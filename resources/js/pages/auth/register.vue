<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { required, email, minLength, maxLength, sameAs } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRouter } from 'vue-router';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Register',
});

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
    <div class="flex-1 flex items-center justify-center p-8 transition-colors duration-300">
        <div class="w-full max-w-md md:max-w-3xl bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 p-8 transition-colors duration-300">
            
            <div class="text-center">
                <div class="w-16 h-16 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-full mx-auto transition-colors">
                    <i class="pi pi-user-plus" style="font-size: 24px;"></i>
                </div>

                <h1 class="mt-4 text-gray-900 dark:text-white transition-colors">Register</h1>

                <p class="text-gray-600 dark:text-gray-400 mt-2 transition-colors">
                    Join me for no raisin.
                </p>
            </div>

            <div class="mt-4">
                <div class="flex flex-col gap-2">
                    <login-with-oauth provider="github"></login-with-oauth>
                    <login-with-oauth provider="twitter"></login-with-oauth>
                </div>

                <div class="relative mt-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-700 transition-colors"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 px-4 transition-colors">or</span>
                    </div>
                </div>

                <form class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4" @submit.prevent="register">
                    <div>
                        <a-input-field input-id="register-name" title="Name" required />

                        <IconField iconPosition="left">
                            <InputIcon class="pi pi-id-card text-gray-500 dark:text-gray-400 transition-colors" />
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
                            <InputIcon class="pi pi-envelope text-gray-500 dark:text-gray-400 transition-colors" />
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

                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 rounded-lg p-2 mt-2 transition-colors">
                            <i class="pi pi-eye-slash text-indigo-500 dark:text-indigo-400"></i>
                            <span>Your email is private and only visible to admins.</span>
                        </div>
                    </div>

                    <div>
                        <a-input-field input-id="register-password" title="Password" required />

                        <Password
                            v-model="v$.password.$model"
                            :invalid="v$.password.$invalid && submitted"
                            input-id="register-password"
                            class="w-full"
                            input-class="w-full"
                            placeholder=""
                            autocomplete="new-password"
                            feedback
                            toggle-mask
                        />

                        <a-field-errors
                            v-if="v$.password.$error && submitted"
                            :errors="v$.password.$errors"
                            name="Password"
                        />
                    </div>

                    <div>
                        <a-input-field input-id="register-confirm-password" title="Confirm Password" required />

                        <Password
                            v-model="v$.password_confirmation.$model"
                            :invalid="v$.password_confirmation.$invalid && submitted"
                            input-id="register-confirm-password"
                            class="w-full"
                            input-class="w-full"
                            placeholder=""
                            autocomplete="new-password"
                            :feedback="false"
                            toggle-mask
                        />

                        <a-field-errors
                            v-if="v$.password_confirmation.$error && submitted"
                            :errors="v$.password_confirmation.$errors"
                            name="Password confirmation"
                        />
                    </div>

                    <Button
                        type="submit"
                        class="w-full md:col-span-2 mt-4"
                        :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-user-plus'"
                        label="Register"
                        :disabled="isSubmitting"
                    />

                </form>

                <div class="text-center text-gray-600 dark:text-gray-400 mt-8 transition-colors">
                    Already have an account?
                    <router-link :to="{ name: 'login' }" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline transition-colors">
                        Login
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>
