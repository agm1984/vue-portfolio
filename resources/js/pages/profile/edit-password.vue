<template>
    <div>
        <a-form v-slot="{ handleSubmit }">
            <a-input-row class="pt-16" type="is-wider-right" heading="Old password">
                <a-text-input
                    v-model="password.name"
                    vid="name"
                    rules="required"
                ></a-text-input>
            </a-input-row>

            <a-input-row class="pt-16" type="is-wider-right" heading="New password">
                <a-text-input
                    v-model="password.name"
                    vid="name"
                    rules="required"
                ></a-text-input>
            </a-input-row>

            <a-input-row class="pt-16" type="is-wider-right" heading="Confirm password">
                <a-text-input
                    v-model="password.name"
                    vid="name"
                    rules="required"
                ></a-text-input>
            </a-input-row>

            <div class="flex items-center justify-end pt-16">
                <a-button @click="handleSubmit(submitForm)">
                    Update
                </a-button>
            </div>
        </a-form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'edit-password',

    scrollToTop: false,

    metaInfo() {
        return { title: 'Edit password' };
    },

    data() {
        return {
            password: {
                old_password: '',
                new_password: '',
                password_confirmation: '',
            },
        };
    },

    methods: {
        async update() {
            await this.form.patch('/api/settings/password');
            this.form.reset();
        },
    },
};
</script>
