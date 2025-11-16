<script setup>
import { ref, reactive, computed } from 'vue';
import { required, sameAs } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRoute, useRouter } from 'vue-router';
import { useHead } from '@unhead/vue';
import Password from 'primevue/password';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Reset password',
})

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const SUCCESS = 'is-success';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);

const form = reactive({
    password: '',
    password_confirmation: '',
});

const newPassword = computed(() => form.password);

const resetPasswordRules = {
    password: { required },
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
  }
}
</script>

<template>
    <div class="flex-1 w-full max-w-3xl mx-auto flex flex-col justify-center p-8">
        <h1>Login</h1>

        <a-card class="w-full flex flex-col p-8 mt-4 self-start">
            <form class="pt-8" @submit.prevent="resetPassword">
                <a-input-field input-id="rp-password" title="New Password" required />

                <Password
                    v-model="v$.password.$model"
                    input-id="profile-new-password"
                    class="w-full"
                    input-class="w-full"
                    autocomplete="new-password"
                    placeholder=""
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

                <a-input-field class="mt-4" input-id="rp-password-confirmation" title="Confirm Password" required />

                <Password
                    v-model="v$.password_confirmation.$model"
                    input-id="rp-password-confirmation"
                    class="w-full"
                    input-class="w-full"
                    :feedback="false"
                    toggle-mask
                    aria-haspopup="false"
                    :invalid="v$.password_confirmation.$invalid && submitted"
                />

                <a-field-errors
                    v-if="v$.password_confirmation.$error && submitted"
                    :errors="v$.password_confirmation.$errors"
                    name="Password Confirmation"
                />

                <Button
                    type="submit"
                    :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-check'"
                    label="Update Password"
                    class="w-full mt-4"
                    :disabled="isSubmitting"
                />
            </form>
        </a-card>
    </div>
</template>
