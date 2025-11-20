<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { helpers, required, email, numeric, minLength, maxLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import axios from 'axios';

// PrimeVue Imports
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import InputNumber from 'primevue/inputnumber';
import Button from 'primevue/button';
import Card from 'primevue/card';

useHead({
    title: 'Contact Me',
});

// --- PURE FUNCTIONS ---
const generateRandom = () => Math.floor((Math.random() * 10) + 1);

// --- STATE ---
const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const SUCCESS = 'is-success';
const state = ref(INITIAL); // 'initial', 'copied', 'submitting'
const submitted = ref(false);
const successMessage = ref('');
const myEmail = 'adam@adammackintosh.net';

// Math Verification
const num1 = ref(generateRandom());
const num2 = ref(generateRandom());

const form = reactive({
    subject: '',
    content: '',
    sender_name: '',
    sender_email: '',
    answer: null, // Changed to null so InputNumber starts empty
});

// --- COMPUTED ---
const isSubmitting = computed(() => state.value === 'submitting');
const isCopiedToClipboard = computed(() => state.value === 'copied');
const showSuccessMessage = computed(() => successMessage.value.length > 0);
const verificationText = computed(() => `What is ${num1.value} + ${num2.value}?`);

// --- VALIDATION ---
const contactRules = {
    subject: { required, maxLength: maxLength(255) },
    content: { required, minLength: minLength(10), maxLength: maxLength(2000) },
    sender_name: { required, maxLength: maxLength(255) },
    sender_email: { required, email, maxLength: maxLength(255) },
    answer: { 
        required, 
        numeric,
        // Pure functional validator: Value must match the sum
        isCorrect: helpers.withMessage('Incorrect!', (value) => {
            if (!helpers.req(value)) return true;
            return value === (num1.value + num2.value);
        }),
    },
};

const v$ = useVuelidate(contactRules, form);

// --- ACTIONS ---

/**
 * Modern Clipboard Copy
 */
const copyEmailToClipboard = async () => {
    if (state.value === 'copied') return;

    try {
        await navigator.clipboard.writeText(myEmail);
        state.value = 'copied';
        setTimeout(() => {
            state.value = 'initial';
        }, 2000);
    } catch (err) {
        console.error('Failed to copy!', err);
    }
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
        form.name = '';
        form.email = '';
        form.subject = '';
        form.content = '';
        form.answer = '';
        submitted.value = false;
        num1.value = generateRandom();
        num2.value = generateRandom();
    } catch (error) {
        console.error(error);
    } finally {
        state.value = INITIAL;
    }
}
</script>

<template>
    <div class="w-full max-w-5xl mx-auto flex items-center p-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 w-full">
            <div class="lg:col-span-1 flex flex-col gap-8">
                <div>
                    <h1>Contact Me</h1>

                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed mt-2">
                        Have a project in mind? Send a message here, or reach out directly via email.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-2 text-indigo-600 dark:text-indigo-400 font-bold text-sm uppercase tracking-wide">
                        <i class="pi pi-envelope"></i>
                        <span>Direct Email</span>
                    </div>
                    <a
                        :href="`mailto:${myEmail}`"
                        class="text-lg font-medium text-gray-800 dark:text-gray-200 hover:text-indigo-600 transition-colors block mb-4 break-all"
                    >
                        {{ myEmail }}
                    </a>
                    <Button
                        type="button"
                        :label="isCopiedToClipboard ? 'Copied!' : 'Copy to Clipboard'" 
                        :icon="isCopiedToClipboard ? 'pi pi-check' : 'pi pi-copy'"
                        :severity="isCopiedToClipboard ? 'success' : 'secondary'"
                        outlined
                        size="small"
                        class="lg:w-full"
                        @click="copyEmailToClipboard"
                    />
                </div>

                <div>
                    <h3 class="text-sm font-bold mb-4">Connect</h3>
                    <div class="flex gap-4">
                        <a-social-link network="twitter" class="hover:translate-x-1 transition-transform" />
                        <a-social-link network="github" class="hover:translate-x-1 transition-transform" />
                        <a-social-link network="stackoverflow" class="hover:translate-x-1 transition-transform" />
                        <a-social-link network="medium" class="hover:translate-x-1 transition-transform" />
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <Card class="shadow-lg border border-gray-100 dark:border-gray-700 dark:bg-gray-800 overflow-hidden">
                    <template #content>
                        <transition name="fade" mode="out-in">
                            <div v-if="showSuccessMessage" class="flex flex-col items-center justify-center py-12 text-center space-y-4">
                                <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-4xl mb-4 animate-bounce">
                                    <i class="pi pi-check"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Message Sent!</h3>
                                <p class="text-gray-600 dark:text-gray-300 max-w-md mb-6">
                                    {{ successMessage }}
                                </p>
                                <Button label="Send Another Message" text @click="successMessage = ''" />
                            </div>

                            <form v-else class="space-y-6 p-2" @submit.prevent="sendMessage">
                                <div>
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
                                </div>

                                <div>
                                    <a-input-field input-id="contact-email" title="Email" required />
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
                                </div>

                                <div>
                                    <a-input-field input-id="contact-subject" title="Subject" required />
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
                                </div>

                                <div>
                                    <a-input-field input-id="contact-content" title="Message" required />
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
                                </div>

                                <div class="flex flex-col sm:flex-row items-end sm:items-center justify-between gap-4 mt-4">
                                    <div class="w-full sm:w-auto">
                                        <label for="contact-answer" class="block font-semibold text-gray-600 dark:text-gray-400 mb-1">
                                            <span>{{ verificationText }}</span>
                                        </label>
                                        <div class="flex flex-col">
                                            <InputNumber
                                                v-model="v$.answer.$model"
                                                input-id="contact-answer"
                                                input-class="w-24"
                                                class="w-24"
                                                :invalid="v$.answer.$invalid && submitted"
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
                                            :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-send'"
                                            label="Send Message"
                                            :disabled="isSubmitting"
                                            class="w-full sm:w-auto"
                                        />
                                    </div>
                                </div>

                            </form>
                        </transition>
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Simple fade transition for the success message swap */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
