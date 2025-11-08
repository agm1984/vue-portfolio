<template>
    <a-card class="p-32">
        <h2 level="1">Reset password</h2>

        <div class="flex justify-center py-16">
            <div class="w-2/3 text-center">
                Enter your email address, and a reset link will be sent to you.
            </div>
        </div>

        <a-form v-slot="{ handleSubmit }" class="pt-16">
            <a-text-input
                v-model="email"
                vid="email"
                rules="required|max:255"
                placeholder="Email"
                required
            ></a-text-input>

            <a-button
                class="mt-8"
                :loading="isSubmitting"
                expanded
                @click="handleSubmit(register)"
            >
                Send password reset link
            </a-button>
        </a-form>

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
