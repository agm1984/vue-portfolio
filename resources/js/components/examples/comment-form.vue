<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { required, minLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { useToast } from 'primevue/usetoast';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

const emit = defineEmits([
    'comment-added',
]);

const currentRoute = useRoute();
const toast = useToast();
const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
// const isInitial = computed(() => state.value === INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const state = ref(INITIAL);
const submitted = ref(false);

const form = reactive({
    body: '',
});

const commentRules = {
    body: { required, minLength: minLength(3) },
};

const v$ = useVuelidate(commentRules, form);

const saveComment = async () => {
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
        };

        const { data } = await axios.post(route('user.comments.create', currentRoute.params.example), formData);

        emit('comment-added', data.comment);

        toast.add({
            severity: 'success',
            summary: 'Posted',
            detail: 'Thanks for your feedback!',
            life: 5000,
        });

        state.value = INITIAL;
        form.body = '';
        submitted.value = false;
    } catch (error) {
        console.log('error', error);
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Could not save comment.',
            life: 5000,
        });
    }
};
</script>

<template>
    <a-card v-if="auth.isAuthenticated" class="p-8">
        <div class="flex gap-4">
            <div class="hidden md:block">
                <a-avatar
                    :user="auth.user"
                    :size="32"
                ></a-avatar>
            </div>

            <form class="flex-1 relative" @submit.prevent="saveComment">
                <Textarea
                    v-model="v$.body.$model"
                    class="w-full focus:ring-0"
                    :invalid="v$.body.$invalid && submitted"
                    placeholder=""
                    rows="3"
                    autoResize
                />

                <a-field-errors
                    v-if="v$.body.$error && submitted"
                    :errors="v$.body.$errors"
                    name="Body"
                />

                <div class="flex items-center justify-between mt-2">
                    <div></div>
                    <!-- <span class="text-xs text-gray-500">Markdown supported</span> -->
                    <Button
                        type="submit"
                        :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-send'"
                        label="Post Comment"
                        :disabled="isSubmitting || !form.body"
                        size="small"
                    />
                </div>
            </form>
        </div>
    </a-card>

    <div v-else class="bg-indigo-50 p-8 rounded-xl border border-indigo-100 dark:border-indigo-800 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <i class="pi pi-lock text-indigo-500 text-xl"></i>
            <span class="text-gray-700 dark:text-gray-300 font-medium">Join the discussion and leave a comment.</span>
        </div>
        <div class="flex gap-4">
            <router-link
                class="text-indigo-600 font-semibold hover:underline"
                :to="{ name: 'login' }"
            >Login</router-link>

            <router-link
                class="text-indigo-600 font-semibold hover:underline"
                :to="{ name: 'register' }"
            >Register</router-link>
        </div>
    </div>
</template>