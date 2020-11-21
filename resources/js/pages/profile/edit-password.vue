<template>
    <div>
        <a-form v-slot="{ handleSubmit }">
            <a-input-row class="pt-16" type="is-wider-right" heading="Old password">
                <a-text-input
                    v-model="password.old_password"
                    vid="name"
                    rules="required"
                ></a-text-input>
            </a-input-row>

            <a-input-row class="pt-16" type="is-wider-right" heading="New password">
                <a-text-input
                    v-model="password.new_password"
                    vid="name"
                    rules="required"
                ></a-text-input>
            </a-input-row>

            <a-input-row class="pt-16" type="is-wider-right" heading="Confirm password">
                <a-text-input
                    v-model="password.password_confirmation"
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

        async submitForm() {
            try {
                const { data } = await axios.put(route('user.password.edit'), this.password);

                console.log('data', data);
                this.$store.dispatch('auth/updateUser', { user: data.user });

            } catch (err) {
                throw new Error(`edit-profile# Problem submitting form: ${err}.`);
            }
        },
    },
};
</script>
