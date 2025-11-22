<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHead } from '@unhead/vue';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Email verification',
});

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();

const status = ref('verifying'); // 'verifying' | 'success' | 'error'
const message = ref('');

// If you want to show which email was verified (optional)
const email = computed(() => auth.user?.email || route.query.email || '');

const verifyEmail = async () => {
    status.value = 'verifying';
    message.value = '';

    const id = route.params.id;
    const search = window.location.search || '';

    try {
        const data = await auth.verifyEmailFromLink(id, search);

        status.value = 'success';
        message.value = data.status || 'Your email has been verified.';
    } catch (error) {
        // Try to surface the backend message if it exists
        const resp = error.response;
        if (resp?.data?.status) {
            message.value = resp.data.status;
        } else {
            message.value = 'We could not verify your email. The link may be invalid or expired.';
        }
        status.value = 'error';
    }
};

onMounted(verifyEmail);

const goToLogin = async () => {
    await router.replace({
        name: 'login',
        query: email.value ? { email: email.value } : undefined,
    });
};
</script>

<template>
    <div class="flex-1 w-full max-w-xl mx-auto flex flex-col items-center justify-center p-8">
        <h1>Email verification</h1>

        <a-card class="w-full flex flex-col p-8 mt-4 self-start">
            <div v-if="status === 'verifying'">
                <p>Verifying your email address, please wait...</p>
            </div>

            <div v-else>
                <p>{{ message }}</p>

                <p v-if="email" class="text-sm text-gray-600 mt-4">
                    <strong>{{ email }}</strong>
                </p>

                <Button
                    type="button"
                    class="w-full mt-4"
                    icon="pi pi-sign-in"
                    :label="auth.isAuthenticated ? 'Go to home' : 'Go to login'"
                    @click="goToLogin"
                />
            </div>
        </a-card>
    </div>
</template>
