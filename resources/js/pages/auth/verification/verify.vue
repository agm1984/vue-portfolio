<script setup>
import { ref, computed } from 'vue';
import { useRoute } from 'vue-router';
import { useHead } from '@unhead/vue';
import Button from 'primevue/button';
import Message from 'primevue/message';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Verify your email',
});

const route = useRoute();
const auth = useAuthStore();

const isSending = ref(false);
const successMessage = ref('');
const errorMessage = ref('');

const email = computed(() => auth.user?.email || route.query.email || '');

const handleResend = async () => {
    try {
        errorMessage.value = '';
        successMessage.value = '';
        isSending.value = true;
        const data = await auth.resendVerificationEmail(email.value);

        successMessage.value = data.message || 'If your email is not yet verified, we have sent you a new verification link.';
    } catch (error) {
        console.error('Error resending verification email:', error);
        errorMessage.value = 'Something went wrong. Please try again in a moment.';
    } finally {
        isSending.value = false;
    }
};
</script>

<template>
    <div class="flex-1 w-full max-w-xl mx-auto flex flex-col items-center justify-center p-8">
        <h1>Verify your email</h1>

        <a-card class="w-full flex flex-col p-8 mt-4 self-start">
            <form @submit.prevent="handleResend" class="w-full flex flex-col">
                <p>
                    We've sent a verification link to
                    <strong v-if="email">{{ email }}</strong>
                    <span v-else>your email address</span>.
                    Please check your inbox and click the link to complete your registration.
                </p>

                <p class="mt-4">
                    Didn't receive the email? You can request another one below.
                </p>

                <Button
                    type="submit"
                    class="w-full mt-4"
                    :icon="isSending ? 'pi pi-spin pi-spinner' : 'pi pi-envelope'"
                    label="Resend verification email"
                    :disabled="isSending || !email"
                />

                <Message v-if="successMessage" severity="success" class="mt-4 text-sm text-green-600">
                    {{ successMessage }}
                </Message>

                <Message v-if="errorMessage" severity="error" class="mt-4 text-sm text-red-600">
                    {{ errorMessage }}
                </Message>
            </form>
        </a-card>
    </div>
</template>
