<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { required, email } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useAuthStore } from '~/store/auth';

// PrimeVue Imports
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';

useHead({
    title: 'Forgot Password',
})

const auth = useAuthStore();

// State Machine
const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const SUCCESS = 'is-success';

const state = ref(INITIAL);
const form = reactive({ email: '' });
const submitted = ref(false);

// Computed
const isSubmitting = computed(() => state.value === SUBMITTING);
const isSuccess = computed(() => state.value === SUCCESS);

// Validation
const rules = {
    email: { required, email },
};
const v$ = useVuelidate(rules, form);

// Actions
const handleSubmit = async () => {
    try {
        state.value = SUBMITTING;
        submitted.value = true;

        const isFormValid = await v$.value.$validate();

        if (!isFormValid) {
            state.value = INITIAL;
            return;
        }

        await auth.forgotPassword(form);

        // Switch UI to success state
        state.value = SUCCESS;
    } catch (error) {
        console.error('Error submitting form:', error);
        state.value = INITIAL;
    }
};
</script>

<template>
    <div class="flex-1 flex items-center justify-center p-8">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <div v-if="isSuccess" class="p-10 text-center flex flex-col items-center animate-fade-in">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-6">
                    <i class="pi pi-envelope text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Check your email</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                    If an account exists for <span class="font-bold text-gray-800 dark:text-white">{{ form.email }}</span>, 
                    you will receive password reset instructions shortly.
                </p>
                <router-link :to="{ name: 'login' }" class="w-full">
                    <Button label="Back to Login" icon="pi pi-arrow-left" class="w-full" outlined />
                </router-link>
            </div>

            <div v-else>
                <div class="p-8 pb-6 text-center">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="pi pi-key text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Forgot Password?</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                        No worries, we'll send you reset instructions.
                    </p>
                </div>

                <div class="px-8 pb-8">
                    <form @submit.prevent="handleSubmit" class="space-y-6">
                        <div>
                            <a-input-field input-id="fp-email" title="Email Address" required />
                            <IconField iconPosition="left">
                                <InputIcon class="pi pi-envelope text-gray-400" />
                                <InputText
                                    v-model="v$.email.$model"
                                    id="fp-email"
                                    :class="['w-full', { 'p-invalid': v$.email.$invalid && submitted }]"
                                    autocomplete="email"
                                    placeholder="Enter your email"
                                />
                            </IconField>

                            <a-field-errors
                                v-if="v$.email.$error && submitted"
                                :errors="v$.email.$errors"
                                name="Email"
                            />
                        </div>

                        <Button
                            type="submit"
                            :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-send'"
                            label="Reset Password"
                            class="w-full font-bold"
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
    </div>
</template>

<style scoped>
/* Simple animation for the success state transition */
.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
