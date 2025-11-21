<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { required, email, maxLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRoute, useRouter } from 'vue-router';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Checkbox from 'primevue/checkbox';
import Button from 'primevue/button';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Login',
});

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);

const form = reactive({
    email: route.query.email || localStorage.getItem('remember_me') || '',
    password: '',
    remember: !!localStorage.getItem('remember_me'),
});

const loginRules = {
    email: { required, email, maxLength: maxLength(255) },
    password: { required },
    remember: {},
};

const v$ = useVuelidate(loginRules, form);

const login = async () => {
    try {
        state.value = SUBMITTING;
        submitted.value = true;

        const isFormValid = await v$.value.$validate();

        if (!isFormValid) {
            state.value = INITIAL;
            return;
        }

        if (form.remember) {
            localStorage.setItem('remember_me', form.email);
        } else {
            localStorage.removeItem('remember_me');
        }

        await auth.login(form);

        await router.push(route.query.redirect ? route.query.redirect : { name: 'home' });
    } catch (error) {
        console.error(error);
    } finally {
        state.value = INITIAL;
    }
};
</script>

<template>
    <div class="flex-1 flex items-center justify-center p-8">
        <a-card class="w-full max-w-md p-8">
            <div class="text-center">
                <div class="w-16 h-16 flex items-center justify-center bg-green-100 text-green-600 rounded-full mx-auto">
                    <i class="pi pi-user" style="font-size: 24px;"></i>
                </div>

                <h1 class="mt-4">Login</h1>

                <p class="text-gray-500 mt-2">
                    Use Oauth or your email and password.
                </p>
            </div>

            <div class="mt-4">
                <div class="flex flex-col gap-2">
                    <login-with-oauth provider="github"></login-with-oauth>
                    <login-with-oauth provider="twitter"></login-with-oauth>
                </div>

                <div class="relative mt-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white dark:bg-gray-800 text-gray-500">or</span>
                    </div>
                </div>

                <form class="mt-4" @submit.prevent="login">
                    <a-input-field input-id="login-email" title="Email" required />

                    <IconField iconPosition="left">
                        <InputIcon class="pi pi-envelope text-gray-400" />
                        <InputText
                            v-model="v$.email.$model"
                            id="login-email"
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

                    <a-input-field class="mt-4" input-id="login-password" title="Password" required />

                    <Password
                        v-model="v$.password.$model"
                        input-id="login-password"
                        class="w-full"
                        input-class="w-full"
                        autocomplete="current-password"
                        :feedback="false"
                        toggle-mask
                        placeholder=""
                        :invalid="v$.password.$invalid && submitted"
                    />

                    <a-field-errors
                        v-if="v$.password.$error && submitted"
                        :errors="v$.password.$errors"
                        name="Password"
                    />

                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center">
                            <Checkbox
                                v-model="v$.remember.$model"
                                input-id="login-remember"
                                binary
                                class="mr-2"
                            />
                            <label for="login-remember" class="cursor-pointer select-none">
                                Remember me
                            </label>
                        </div>

                        <router-link
                            class="font-semibold text-indigo-600 hover:text-indigo-500 hover:underline"
                            :to="{ name: 'password.request' }"
                        >
                            Forgot password?
                        </router-link>
                    </div>

                    <Button
                        type="submit"
                        class="w-full mt-4"
                        :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-sign-in'"
                        label="Login"
                        :disabled="isSubmitting"
                    />
                </form>

                <div class="text-center mt-8">
                    Don't have an account?
                    <router-link :to="{ name: 'register' }" class="font-semibold text-indigo-600 hover:underline ml-1">
                        Register
                    </router-link>
                </div>
            </div>
        </a-card>
    </div>
</template>
