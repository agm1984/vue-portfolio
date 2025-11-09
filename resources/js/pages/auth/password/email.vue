<script setup>
import { ref, reactive, computed } from 'vue';
import { required, email, maxLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);

const form = reactive({
    email: '',
});

const forgotPasswordRules = {
    email: { required, email, maxLength: maxLength(255) },
};

const v$ = useVuelidate(forgotPasswordRules, form);

const handleSubmit = async () => {
    try {
        state.value = SUBMITTING;
        submitted.value = true;

        const isFormValid = await v$.value.$validate();

        if (!isFormValid) {
            console.log('Form is invalid');
            state.value = INITIAL;
            return;
        }

        await auth.forgotPassword(form);
    } catch (error) {
        console.error('Error submitting form:', error);
    } finally {
        state.value = INITIAL;
    }
};
</script>

<template>
    <a-card class="w-full max-w-3xl flex flex-col p-8">
        <h1>Reset password</h1>

        <div class="flex justify-center py-8">
            <div class="w-2/3 text-center">
                Enter your email address, and a reset link will be sent to you.
            </div>
        </div>

        <form class="pt-8" @submit.prevent="handleSubmit">
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
                class="mt-8 w-full"
                :disabled="isSubmitting"
            />
        </form>

    </a-card>
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
