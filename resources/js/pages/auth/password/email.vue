<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { required, email } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Forgot Password',
})

const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const SUCCESS = 'is-success';

const state = ref(INITIAL);
const form = reactive({ email: '' });
const submitted = ref(false);

const isSubmitting = computed(() => state.value === SUBMITTING);
const isSuccess = computed(() => state.value === SUCCESS);

const rules = {
    email: { required, email },
};
const v$ = useVuelidate(rules, form);

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

        state.value = SUCCESS;
    } catch (error) {
        console.error('Error submitting form:', error);
        state.value = INITIAL;
    }
};
</script>

<template>
    <div class="flex-1 flex items-center justify-center p-8 transition-colors duration-300">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 p-8 transition-colors duration-300">
            <div v-if="isSuccess" class="flex flex-col items-center text-center animate-fade-in">
                <div class="w-16 h-16 flex items-center justify-center bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-full transition-colors mb-4">
                    <i class="pi pi-envelope" style="font-size: 24px;"></i>
                </div>

                <a-page-title
                    title="Check your email"
                    centered
                >
                    <template #description>
                        <p class="text-gray-600 dark:text-gray-400">
                            If an account exists for <span class="font-semibold text-gray-900 dark:text-white">{{ form.email }}</span>,
                            you will receive password reset instructions shortly.
                        </p>
                    </template>
                </a-page-title>

                <router-link class="w-full" :to="{ name: 'login' }">
                    <Button
                        type="button"
                        class="w-full"
                        icon="pi pi-arrow-left"
                        label="Back to Login"
                        outlined
                    />
                </router-link>
            </div>

            <div v-else>
                <div class="text-center">
                    <div class="w-16 h-16 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-full mx-auto transition-colors mb-4">
                        <i class="pi pi-key" style="font-size: 24px;"></i>
                    </div>

                    <a-page-title
                        title="Forgot Password?"
                        description="No worries, I will send you reset instructions."
                        centered
                    ></a-page-title>
                </div>

                <form class="mt-4" @submit.prevent="handleSubmit">
                    <a-input-field input-id="fp-email" title="Email" required />

                    <IconField iconPosition="left">
                        <InputIcon class="pi pi-envelope text-gray-500 dark:text-gray-400" />
                        <InputText
                            v-model="v$.email.$model"
                            id="fp-email"
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

                    <Button
                        type="submit"
                        class="w-full mt-4"
                        :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-send'"
                        label="Reset Password"
                        :disabled="isSubmitting"
                    />
                </form>

                <div class="text-center mt-8">
                    <router-link
                        class="flex items-center justify-center gap-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 active:text-indigo-800 font-semibold transition-colors"
                        :to="{ name: 'login' }"
                    >
                        <i class="pi pi-arrow-left"></i>
                        Back to Login
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
