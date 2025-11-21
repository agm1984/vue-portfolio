<script setup>
import { ref, reactive, computed } from 'vue';
import { required, sameAs, minLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRoute, useRouter } from 'vue-router';
import { useHead } from '@unhead/vue';
import Password from 'primevue/password';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Reset Password',
})

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);

const form = reactive({
    password: '',
    password_confirmation: '',
});

const newPassword = computed(() => form.password);

const resetPasswordRules = {
    password: { required, minLength: minLength(8) },
    password_confirmation: { required, sameAs: sameAs(newPassword) },
};

const v$ = useVuelidate(resetPasswordRules, form);

const resetPassword = async () => {
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
        token: route.params.token,
        email: route.query.email,
    };

    await auth.resetPassword(formData);

    await router.replace({
        name: 'login',
        query: {
            email: route.query.email,
        },
    });
  } catch (error) {
    console.error('Error resetting password:', error)
    state.value = INITIAL;
  }
}
</script>

<template>
    <div class="flex-1 flex items-center justify-center p-8">
        <a-card class="w-full max-w-md p-8">
            <div class="text-center">
                <div class="w-16 h-16 flex items-center justify-center bg-indigo-100 text-indigo-600 rounded-full mx-auto">
                    <i class="pi pi-lock-open" style="font-size: 24px;"></i>
                </div>

                <h1 class="mt-4">Set New Password</h1>

                <p class="text-gray-500 mt-2">
                    Please choose a strong password to secure your account.
                </p>
            </div>

            <form class="mt-4" @submit.prevent="resetPassword">
                <a-input-field input-id="rp-password" title="New Password" required />

                <Password
                    v-model="v$.password.$model"
                    input-id="rp-password"
                    class="w-full"
                    input-class="w-full"
                    autocomplete="new-password"
                    placeholder=""
                    :feedback="true"
                    toggle-mask
                    :invalid="v$.password.$invalid && submitted"
                />

                <a-field-errors
                    v-if="v$.password.$error && submitted"
                    :errors="v$.password.$errors"
                    name="Password"
                />

                <a-input-field class="mt-4" input-id="rp-password-confirmation" title="Confirm Password" required />

                <Password
                    v-model="v$.password_confirmation.$model"
                    input-id="rp-password-confirmation"
                    class="w-full"
                    input-class="w-full"
                    autocomplete="new-password"
                    placeholder=""
                    :feedback="false"
                    toggle-mask
                    :invalid="v$.password_confirmation.$invalid && submitted"
                />

                <a-field-errors
                    v-if="v$.password_confirmation.$error && submitted"
                    :errors="v$.password_confirmation.$errors"
                    name="Confirmation"
                />

                <Button
                    type="submit"
                    class="w-full font-bold mt-4"
                    :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-check-circle'"
                    label="Update Password"
                    :disabled="isSubmitting"
                />

            </form>

            <div class="text-center mt-8">
                <router-link
                    class="flex items-center justify-center gap-2 text-indigo-600 hover:text-indigo-700 active:text-indigo-800 font-semibold transition-colors"
                    :to="{ name: 'login' }"
                >
                    <i class="pi pi-arrow-left"></i>
                    Back to Login
                </router-link>
            </div>
        </a-card>
    </div>
</template>
