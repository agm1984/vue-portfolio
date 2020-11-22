<template>
    <div class="">
        <a-form v-slot="{ handleSubmit }" has-files>
            <div class="flex items-center justify-center">
                <a-single-image-input
                    v-model="profile.avatar"
                    :user="user"
                ></a-single-image-input>
            </div>

            <a-input-row class="pt-16" type="is-wider-right" heading="Name">
                <a-text-input
                    v-model="profile.name"
                    vid="name"
                    rules="required"
                ></a-text-input>
            </a-input-row>

            <a-input-row class="pt-16" type="is-wider-right" heading="Email">
                <a-text-input
                    v-model="profile.email"
                    vid="email"
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
    name: 'edit-profile',

    scrollToTop: false,

    metaInfo() {
        return { title: 'Edit profile' };
    },

    data() {
        return {
            profile: {
                avatar: '',
                name: '',
                email: '',
            },
        };
    },

    computed: {
        user() {
            return this.$store.getters['auth/user'];
        },

    },

    created() {
        // console.log('user', this.user);
        this.profile.name = this.user.name;
        this.profile.email = this.user.email;
    },

    methods: {


        async submitForm() {
            try {
                const payload = new FormData();

                payload.append('avatar', this.profile.avatar);
                payload.append('name', this.profile.name);
                payload.append('email', this.profile.email);

                const { data } = await axios.post(route('user.profile.edit'), payload);

                console.log('data', data.user);
                this.$store.dispatch('auth/updateUser', { user: data.user });

            } catch (err) {
                throw new Error(`edit-profile# Problem submitting form: ${err}.`);
            }
        },

    },

};
</script>
