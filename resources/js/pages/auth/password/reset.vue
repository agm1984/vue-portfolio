<script setup>
import { ref, reactive, computed } from 'vue';
import { required, sameAs, minLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRoute, useRouter } from 'vue-router';
import { useHead } from '@unhead/vue';
import { useAuthStore } from '~/store/auth';

// PrimeVue Imports
import Password from 'primevue/password';
import Button from 'primevue/button';

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

    // Redirect to login with the email pre-filled
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
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="p-8 pb-6 text-center">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="pi pi-lock-open text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Set New Password</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                    Please choose a strong password to secure your account.
                </p>
            </div>

            <div class="px-8 pb-8">
                <form class="space-y-5" @submit.prevent="resetPassword">
                    <div>
                        <a-input-field input-id="rp-password" title="New Password" required />
                        <div class="relative">
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
                        </div>
                        <a-field-errors
                            v-if="v$.password.$error && submitted"
                            :errors="v$.password.$errors"
                            name="Password"
                        />
                    </div>

                    <div>
                        <a-input-field input-id="rp-password-confirmation" title="Confirm Password" required />
                        <div class="relative">
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
                        </div>
                        <a-field-errors
                            v-if="v$.password_confirmation.$error && submitted"
                            :errors="v$.password_confirmation.$errors"
                            name="Confirmation"
                        />
                    </div>

                    <Button
                        type="submit"
                        :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-check-circle'"
                        label="Update Password"
                        class="w-full font-bold mt-4"
                        :disabled="isSubmitting"
                    />

                </form>

                <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    <router-link :to="{ name: 'login' }" class="flex items-center justify-center gap-2 hover:text-indigo-600 transition-colors font-medium">
                        <i class="pi pi-arrow-left text-xs"></i>
                        Back to Login
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>
