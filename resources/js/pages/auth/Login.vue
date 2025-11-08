<script setup>
import { ref, reactive, computed, onBeforeMount } from 'vue';
import { required, email, maxLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRouter } from 'vue-router';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Checkbox from 'primevue/checkbox';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

const router = useRouter();
const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);

const form = reactive({
    email: localStorage.getItem('remember_me') || '',
    password: '',
    remember: true,
});

const loginRules = {
    email: { required, email, maxLength: maxLength(255) },
    password: { required },
    remember: {},
};

const v$ = useVuelidate(loginRules, form);

const hasIntendedUrl = computed(() => auth.intendedUrl.length > 0);

onBeforeMount(async () => {
    if (hasIntendedUrl.value) {
        await router.replace({
            name: 'login',
            query: {
                redirect: auth.intendedUrl,
            },
        });
    }
});

const login = async () => {
    try {
        state.value = SUBMITTING;
        submitted.value = true;

        const isFormValid = await v$.value.$validate();

        if (!isFormValid) {
            console.log('Form is invalid');
            state.value = INITIAL;
            return;
        }

        if (form.remember_me) {
            localStorage.setItem('remember_me', form.email);
        } else {
            localStorage.removeItem('remember_me');
        }

        await auth.login(form);
    } catch (error) {
        console.error(error);
    } finally {
        state.value = INITIAL;
    }
};
</script>

<template>
    <div class="flex justify-center p-16">
        <a-card class="w-full max-w-3xl flex flex-col p-8">
            <h1>Login</h1>

            <div class="flex flex-col">
                <!-- <login-with-oauth provider="github"></login-with-oauth> -->
                <!-- <login-with-oauth provider="twitter" class="mt-8"></login-with-oauth> -->
            </div>

            <div class="flex items-center pt-8">
                <hr class="inline w-full">
                <span class="mx-8">or</span>
                <hr class="inline w-full">
            </div>

            <form class="pt-8" @submit.prevent="login">
                <a-input-field input-id="login-email" title="Email" required />

                <InputText
                    v-model="v$.email.$model"
                    id="login-email"
                    :class="['w-full', { 'p-invalid': v$.email.$invalid && submitted }]"
                    autocomplete="email"
                    placeholder=""
                />

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
                    aria-haspopup="false"
                    :invalid="v$.password.$invalid && submitted"
                />

                <a-field-errors
                    v-if="v$.password.$error && submitted"
                    :errors="v$.password.$errors"
                    name="Password"
                />

                <Button
                    type="submit"
                    :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-check'"
                    label="Login"
                    class="mt-8 w-full"
                    :disabled="isSubmitting"
                />

                <div class="flex items-center justify-between pt-4">
                    <div class="flex items-center">
                        <Checkbox
                            v-model="v$.remember.$model"
                            input-id="login-remember"
                            binary
                        />
                        <label for="login-remember" class="ml-2">Remember Me</label>
                    </div>

                    <router-link class="font-semibold hover:underline" :to="{ name: 'password.request' }">
                        Forgot password?
                    </router-link>
                </div>
            </form>

        </a-card>
    </div>
</template>
