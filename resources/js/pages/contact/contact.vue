<script setup>
import { ref, reactive, computed, watch } from 'vue';
import { useHead } from '@unhead/vue';
import { required, email, numeric, minLength, maxLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import axios from 'axios';
import Message from 'primevue/message';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import InputNumber from 'primevue/inputnumber';
import Button from 'primevue/button';

useHead({
    title: 'Contact',
});

/**
 * Creates a random number used for creation of mathematical solutions
 * that are used for a human verification step before submitting.
 */
const generateRandom = () => Math.floor((Math.random() * 10) + 1);

const INITIAL = 'is-initial';
const IS_COPIED_TO_CLIPBOARD = 'is-copied-to-clipboard';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);
const myEmail = 'adam@adammackintosh.net';
const num1 = ref(generateRandom());
const num2 = ref(generateRandom());
const isFormVerified = ref(false);
const successMessage = ref('');

const form = reactive({
    subject: '',
    content: '',
    sender_name: '',
    sender_email: '',
    answer: '',
});

const contactRules = {
    subject: { required, maxLength: maxLength(255) },
    content: { required, minLength: minLength(10), maxLength: maxLength(2000) },
    sender_name: { required, maxLength: maxLength(255) },
    sender_email: { required, email, maxLength: maxLength(255) },
    answer: { required, numeric },
};

const v$ = useVuelidate(contactRules, form);

const isInitial = computed(() => state.value === INITIAL);
const isCopiedToClipboard = computed(() => state.value === IS_COPIED_TO_CLIPBOARD);
const messageAnswer = computed(() => +form.answer);
const verificationText = computed(() => `${num1.value} + ${num2.value} =`);
const showSuccessMessage = computed(() => successMessage.value.length > 0);

watch(messageAnswer, (newVal) => {
    const solution = num1.value + num2.value;
    isFormVerified.value = newVal === solution;
});

const copyEmailToClipboard = () => {
    const textField = document.createElement('textarea');

    textField.innerText = myEmail;
    document.body.appendChild(textField);
    textField.select();
    document.execCommand('copy');
    textField.remove();

    if (isCopiedToClipboard.value) return;

    state.value = IS_COPIED_TO_CLIPBOARD;

    setTimeout(() => {
        state.value = INITIAL;
    }, 1618);
}

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
    <div class="w-full max-w-5xl mx-auto h-auto flex-1 flex flex-col p-8">
        <Message v-show="showSuccessMessage" class="mb-4" severity="success">
            {{ successMessage }}
        </Message>

        <div class="flex flex-col w-full">
            <h1>Contact Me</h1>

            <a-card class="w-full flex gap-4 p-8 mt-4">
                <div class="w-full flex flex-col gap-4">
                    <span class="font-semibold">Ready to get in touch?</span>

                    <p>
                        Send a message here, or email me at
                        <a class="font-semibold hover:underline" :href="`mailto:${myEmail}`">{{ myEmail }}</a>
                        <span v-if="isCopiedToClipboard" class="text-green-500 ml-2">✓</span>
                    </p>

                    <div v-if="!isCopiedToClipboard">
                        <Button
                            type="button"
                            severity="secondary"
                            title="Copy email address into clipboard"
                            @click="copyEmailToClipboard"
                        >
                            Copy email to clipboard
                        </Button>
                    </div>
                </div>

                <div class="flex flex-col bg-gray-200 rounded-md p-4">
                    <h3 class="whitespace-nowrap">Find me on social media</h3>
                    <a-social-link class="pt-4 pl-8" network="twitter">Twitter</a-social-link>
                    <a-social-link class="pt-4 pl-8" network="github">GitHub</a-social-link>
                    <a-social-link class="pt-4 pl-8" network="stackoverflow">StackOverflow</a-social-link>
                    <a-social-link class="pt-4 pl-8" network="medium">Medium</a-social-link>
                </div>
            </a-card>

            <form
                class="mt-8"
                @submit.prevent="sendMessage"
            >
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

                <a-input-field class="mt-4" input-id="contact-content" title="Content" required />

                <Textarea
                    v-model="v$.content.$model"
                    id="contact-content"
                    :class="['w-full', { 'p-invalid': v$.content.$invalid && submitted }]"
                    autocomplete="off"
                    placeholder=""
                    rows="6"
                    maxlength="2000"
                />

                <a-field-errors
                    v-if="v$.content.$error && submitted"
                    :errors="v$.content.$errors"
                    name="Content"
                />

                <div class="flex justify-end gap-2 mt-4">
                    <label for="contact-answer" class="mt-2">{{ verificationText }}</label>

                    <div>
                        <div class="w-full flex gap-2">
                            <InputNumber
                                v-model="v$.answer.$model"
                                input-id="contact-answer"
                                :invalid="v$.answer.$invalid && submitted"
                                class="w-16"
                                input-class="w-16"
                                autocomplete="off"
                                placeholder=""
                            />

                            <Button
                                type="submit"
                                :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-check'"
                                label="Send"
                                :disabled="isSubmitting"
                            />
                        </div>

                        <a-field-errors
                            v-if="v$.answer.$error && submitted"
                            :errors="v$.answer.$errors"
                            name="Correct answer"
                        />
                    </div>
                </div>
            </form>
        </div>

    </div>
</template>
