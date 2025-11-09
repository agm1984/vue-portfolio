<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { required, minLength, sameAs } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import axios from 'axios';
import Password from 'primevue/password';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);

const form = reactive({
    old_password: '',
    new_password: '',
    password_confirmation: '',
});

const newPassword = computed(() => form.new_password);

const profileRules = {
    old_password: { required },
    new_password: { required, minLength: minLength(6) },
    password_confirmation: { required, sameAs: sameAs(newPassword) },
};

const v$ = useVuelidate(profileRules, form);

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

        const { data } = await axios.put(route('user.password.edit'), form);

        console.log('data', data);
        auth.updateUser(data);
    } catch (error) {
        console.error(error);
    } finally {
        state.value = INITIAL;
    }
};
</script>

<template>
    <div>
        <form @submit.prevent="handleSubmit">
            <a-input-field input-id="profile-old-password" title="Old password" required />

            <Password
                v-model="v$.old_password.$model"
                id="profile-old-password"
                class="w-full"
                input-class="w-full"
                placeholder=""
                autocomplete="current-password"
                :feedback="false"
                toggle-mask
                aria-haspopup="false"
                :invalid="v$.old_password.$invalid && submitted"
            />

            <a-field-errors
                v-if="v$.old_password.$error && submitted"
                :errors="v$.old_password.$errors"
                name="Old password"
            />

            <a-input-field class="mt-4" input-id="profile-new-password" title="New password" required />

            <Password
                v-model="v$.new_password.$model"
                input-id="profile-new-password"
                class="w-full"
                input-class="w-full"
                autocomplete="new-password"
                placeholder=""
                :feedback="false"
                toggle-mask
                aria-haspopup="false"
                :invalid="v$.new_password.$invalid && submitted"
            />

            <a-field-errors
                v-if="v$.new_password.$error && submitted"
                :errors="v$.new_password.$errors"
                name="New password"
            />

            <a-input-field class="mt-4" input-id="profile-password-confirmation" title="Confirm Password" required />

            <Password
                v-model="v$.password_confirmation.$model"
                input-id="profile-password-confirmation"
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
                class="mt-8 w-full"
                :disabled="isSubmitting"
            />
        </form>
    </div>
</template>
