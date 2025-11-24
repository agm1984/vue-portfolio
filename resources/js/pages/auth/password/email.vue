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
    <div class="flex-1 flex items-center justify-center p-8">
        <a-card class="w-full max-w-md p-8">
            <div v-if="isSuccess" class="flex flex-col items-center text-center animate-fade-in">
                <div class="w-16 h-16 flex items-center justify-center bg-green-100 text-green-600 rounded-full">
                    <i class="pi pi-envelope" style="font-size: 24px;"></i>
                </div>

                <h2 class="mt-4">Check your email</h2>

                <p class="text-gray-600 mt-2">
                    If an account exists for <span class="font-semibold">{{ form.email }}</span>,
                    you will receive password reset instructions shortly.
                </p>

                <router-link class="w-full mt-4" :to="{ name: 'login' }">
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
                    <div class="w-16 h-16 flex items-center justify-center bg-indigo-100 text-indigo-600 rounded-full mx-auto">
                        <i class="pi pi-key" style="font-size: 24px;"></i>
                    </div>

                    <h1 class="mt-4">Forgot Password?</h1>

                    <p class="text-gray-600 mt-2">
                        No worries, I will send you reset instructions.
                    </p>
                </div>

                <form class="mt-4" @submit.prevent="handleSubmit">
                    <a-input-field input-id="fp-email" title="Email" required />

                    <IconField iconPosition="left">
                        <InputIcon class="pi pi-envelope text-gray-500" />
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
                        class="flex items-center justify-center gap-2 text-indigo-600 hover:text-indigo-700 active:text-indigo-800 font-semibold transition-colors"
                        :to="{ name: 'login' }"
                    >
                        <i class="pi pi-arrow-left"></i>
                        Back to Login
                    </router-link>
                </div>
            </div>
        </a-card>
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
