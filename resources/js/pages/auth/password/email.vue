<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { required, email } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Message from 'primevue/message';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Forgot Password',
})

const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const SUCCESS = 'is-success';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const isSuccess = computed(() => state.value === SUCCESS);
const submitted = ref(false);
const successMessage = ref('');

const form = reactive({
    email: '',
});

const forgotPasswordRules = {
    email: { required, email },
};

const v$ = useVuelidate(forgotPasswordRules, form);

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

        successMessage.value = 'If your email address exists in my system, you will receive a password reset link shortly.';
        state.value = SUCCESS;
    } catch (error) {
        console.error('Error submitting form:', error);
        state.value = INITIAL;
    }
};
</script>

<template>
    <div class="flex-1 w-full max-w-3xl mx-auto flex flex-col items-center justify-center p-8">
        <h1>Reset password</h1>

        <a-card class="p-8 mt-4">
            <div class="flex justify-center">
                <Message
                    v-if="isSuccess"
                    class="w-full max-w-md text-center"
                    severity="success"
                >
                    <i class="pi pi-envelope mr-2"></i>
                    {{ successMessage }}
                </Message>

                <p v-else class="max-w-[250px] text-center">Enter your email address, and a reset link will be sent to you.</p>
            </div>

            <form class="pt-4" @submit.prevent="handleSubmit">
                <a-input-field input-id="fp-email" title="Email" required />

                <InputText
                    v-model="v$.email.$model"
                    id="fp-email"
                    :class="['w-full', { 'p-invalid': v$.email.$invalid && submitted }]"
                    autocomplete="email"
                    placeholder=""
                />

                <a-field-errors
                    v-if="v$.email.$error && submitted"
                    :errors="v$.email.$errors"
                    name="Email"
                />

                <Button
                    type="submit"
                    :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-check'"
                    label="Send password reset link"
                    class="mt-4 w-full"
                    :disabled="isSubmitting || isSuccess"
                />
            </form>

        </a-card>
    </div>
</template>

<script>
// import axios from 'axios';

const INITIAL = 'INITIAL';
const SUBMITTING = 'SUBMITTING';

export default {
    middleware: 'guest',

    metaInfo() {
        return { title: 'Reset password' };
    },

    data() {
        return {
            state: INITIAL,
            email: '',
        };
    },

    computed: {
        isInitial() {
            return (this.state === INITIAL);
        },

        isSubmitting() {
            return (this.state === SUBMITTING);
        },
    },

    methods: {
        async submitForm() {
            try {
                this.state = SUBMITTING;

                // todo (this isn't really needed)
            } catch (err) {
                this.state = INITIAL;

                throw new Error(`email# Problem registering new user: ${err}.`);
            }
        },

    },
};
</script>
