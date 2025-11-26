<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { helpers, required, email, numeric, minLength, maxLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import axios from 'axios';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import InputNumber from 'primevue/inputnumber';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Contact Me',
});

const auth = useAuthStore();

const myEmail = 'adam@adammackintosh.net';
const INITIAL = 'is-initial';
const COPIED = 'is-copied';
const SUBMITTING = 'is-submitting';
const MESSAGE_SENT = 'is-message-sent';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const isCopiedToClipboard = computed(() => state.value === COPIED);
const isMessageSent = computed(() => state.value === MESSAGE_SENT);
const submitted = ref(false);

const generateRandom = () => Math.floor((Math.random() * 10) + 1);
const num1 = ref(generateRandom());
const num2 = ref(generateRandom());
const successMessage = ref('');
const verificationText = computed(() => `What is ${num1.value} + ${num2.value}?`);

const form = reactive({
    sender_name: auth.isAuthenticated ? auth.user.name : '',
    sender_email: auth.isAuthenticated ? auth.user.email : '',
    subject: '',
    content: '',
    answer: null,
});

const contactRules = {
    sender_name: { required, maxLength: maxLength(255) },
    sender_email: { required, email, maxLength: maxLength(255) },
    subject: { required, maxLength: maxLength(255) },
    content: { required, minLength: minLength(10), maxLength: maxLength(2000) },
    answer: {
        required,
        numeric,
        isCorrect: helpers.withMessage('Incorrect!', (value) => {
            if (!helpers.req(value)) return true;
            return value === (num1.value + num2.value);
        }),
    },
};

const v$ = useVuelidate(contactRules, form);

const copyEmailToClipboard = async () => {
    if (state.value === COPIED) return;

    try {
        await navigator.clipboard.writeText(myEmail);
        state.value = COPIED;
        setTimeout(() => {
            state.value = INITIAL;
        }, 2000);
    } catch (err) {
        console.error('Failed to copy!', err);
    }
};

const resetForm = () => {
    form.sender_name = auth.isAuthenticated ? auth.user.name : '';
    form.sender_email = auth.isAuthenticated ? auth.user.email : '';
    form.subject = '';
    form.content = '';
    form.answer = '';
    num1.value = generateRandom();
    num2.value = generateRandom();
    submitted.value = false;
    state.value = INITIAL;
    successMessage.value = '';
};

const sendMessage = async () => {
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

        const { data } = await axios.post(route('public.contact.send'), formData);

        successMessage.value = data.message;

        state.value = MESSAGE_SENT;
    } catch (error) {
        console.error(error);
        state.value = INITIAL;
    }
}
</script>

<template>
    <div class="flex-1 w-full max-w-5xl mx-auto flex items-center p-8 transition-colors duration-300">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 w-full">
            <div class="lg:col-span-1 flex flex-col">
                <a-page-title
                    title="Contact Me"
                    description="Have a project in mind? Send a message here, or reach out directly via email."
                ></a-page-title>

                <a-card class="p-8">
                    <div class="flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide">
                        <i class="pi pi-envelope"></i>
                        <span>Direct Email</span>
                    </div>

                    <a
                        :href="`mailto:${myEmail}`"
                        class="text-lg text-gray-800 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors block break-all mt-2"
                    >
                        {{ myEmail }}
                    </a>

                    <Button
                        type="button"
                        class="lg:w-full mt-2"
                        :severity="isCopiedToClipboard ? 'success' : 'secondary'"
                        :icon="isCopiedToClipboard ? 'pi pi-check' : 'pi pi-copy'"
                        :label="isCopiedToClipboard ? 'Copied!' : 'Copy to Clipboard'"
                        size="small"
                        outlined
                        @click="copyEmailToClipboard"
                    />
                </a-card>

                <div class="mt-8">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Connect</h3>
                    <div class="flex gap-4 mt-4">
                        <a-social-link network="twitter" class="hover:translate-x-1 transition-transform" />
                        <a-social-link network="github" class="hover:translate-x-1 transition-transform" />
                        <a-social-link network="stackoverflow" class="hover:translate-x-1 transition-transform" />
                        <a-social-link network="medium" class="hover:translate-x-1 transition-transform" />
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <a-card class="p-8">
                    <transition name="fade" mode="out-in">
                        <div v-if="isMessageSent" class="flex flex-col items-center justify-center text-center py-8">
                            <div class="w-20 h-20 flex items-center justify-center bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-full animate-bounce">
                                <i class="pi pi-check" style="font-size: 24px;"></i>
                            </div>

                            <h3 class="mt-4 text-gray-900 dark:text-white">Message Sent!</h3>

                            <p class="max-w-md mt-4 text-gray-600 dark:text-gray-300">
                                {{ successMessage }}
                            </p>
                            <Button
                                type="button"
                                class="mt-4"
                                severity="secondary"
                                icon="pi pi-send"
                                label="Send Another Message"
                                @click="resetForm"
                            />
                        </div>

                        <form v-else @submit.prevent="sendMessage">
                            <a-input-field input-id="contact-name" title="Name" required />

                            <InputText
                                v-model="v$.sender_name.$model"
                                id="contact-name"
                                :class="['w-full', { 'p-invalid': v$.sender_name.$invalid && submitted }]"
                                autocomplete="name"
                                placeholder=""
                            />

                            <a-field-errors
                                v-if="v$.sender_name.$error && submitted"
                                :errors="v$.sender_name.$errors"
                                name="Name"
                            />

                            <a-input-field class="mt-4" input-id="contact-email" title="Email" required />

                            <InputText
                                v-model="v$.sender_email.$model"
                                id="contact-email"
                                :class="['w-full', { 'p-invalid': v$.sender_email.$invalid && submitted }]"
                                autocomplete="email"
                                placeholder=""
                            />

                            <a-field-errors
                                v-if="v$.sender_email.$error && submitted"
                                :errors="v$.sender_email.$errors"
                                name="Email"
                            />

                            <a-input-field class="mt-4" input-id="contact-subject" title="Subject" required />

                            <InputText
                                v-model="v$.subject.$model"
                                id="contact-subject"
                                :class="['w-full', { 'p-invalid': v$.subject.$invalid && submitted }]"
                                autocomplete="off"
                                placeholder=""
                            />

                            <a-field-errors
                                v-if="v$.subject.$error && submitted"
                                :errors="v$.subject.$errors"
                                name="Subject"
                            />

                            <a-input-field class="mt-4" input-id="contact-content" title="Message" required />

                            <Textarea
                                v-model="v$.content.$model"
                                id="contact-content"
                                :class="['w-full', { 'p-invalid': v$.content.$invalid && submitted }]"
                                rows="6"
                                maxlength="2000"
                                autoResize
                            />

                            <a-field-errors
                                v-if="v$.content.$error && submitted"
                                :errors="v$.content.$errors"
                                name="Content"
                            />

                            <div class="flex flex-col sm:flex-row items-end sm:items-center justify-between gap-4 mt-4">
                                <div class="w-full sm:w-auto">
                                    <label for="contact-answer" class="block font-semibold text-gray-600 dark:text-gray-300 mb-1">
                                        <span>{{ verificationText }}</span>
                                    </label>

                                    <div class="flex flex-col">
                                        <InputNumber
                                            v-model="v$.answer.$model"
                                            :invalid="v$.answer.$invalid && submitted"
                                            input-id="contact-answer"
                                            input-class="w-24"
                                            class="w-24"
                                            placeholder=""
                                        />

                                        <a-field-errors
                                            v-if="v$.answer.$error && submitted"
                                            :errors="v$.answer.$errors"
                                            name="Answer"
                                        />
                                    </div>
                                </div>

                                <div class="w-full sm:w-auto">
                                    <Button
                                        type="submit"
                                        class="w-full sm:w-auto"
                                        :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-send'"
                                        label="Send Message"
                                        :disabled="isSubmitting"
                                    />
                                </div>
                            </div>

                        </form>
                    </transition>
                </a-card>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.3s ease;
    }

    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
</style>
