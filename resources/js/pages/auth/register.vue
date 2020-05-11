<template>
    <div class="">
        <a-heading level="1">Register</a-heading>

        <a-form v-slot="{ handleSubmit }">
            <a-text-input
                v-model="fields.name"
                vid="name"
                rules="required|max:255"
                placeholder="Name"
                required
            ></a-text-input>

            <a-text-input
                v-model="fields.email"
                vid="email"
                rules="required|email|max:255"
                placeholder="Email"
                required
            ></a-text-input>

            <a-text-input
                v-model="fields.password"
                vid="password"
                rules="required|min:8"
                placeholder="Password"
                type="password"
                required
            ></a-text-input>

            <div class="flex items-center">
                <checkbox v-model="fields.remember" name="remember">
                    Remember me
                </checkbox>

                <router-link :to="{ name: 'password.request' }" class="my-auto ml-auto small">
                    Forgot password?
                </router-link>
            </div>

            <div class="flex flex-col">
                <a-button @click="handleSubmit(register)">
                    Register
                </a-button>

                <login-with-oauth provider="github"></login-with-oauth>
                <login-with-oauth provider="twitter"></login-with-oauth>
            </div>
        </a-form>

    </div>
</template>

<script>
import axios from 'axios';
import Form from 'vform';
import LoginWithOauth from '~/components/login-with-oauth.vue';

export default {
    middleware: 'guest',

    components: {
        LoginWithOauth,
    },

    metaInfo() {
        return { title: 'Register' };
    },

    data() {
        return {
            fields: {
                email: '',
                password: '',
                remember: true,
            },
            form: new Form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            }),
            mustVerifyEmail: false,
        };
    },

    methods: {
        async register() {
            try {
                const { data } = await axios.post(route('register'), this.fields);
                const { user, token } = data;

                this.$store.dispatch('auth/saveToken', { token });

                await this.$store.dispatch('auth/updateUser', { user });

                this.$router.push({ name: 'home' });
            } catch (err) {
                console.log('err', err.response);
                throw new Error(`register# Problem registering new user: ${err}.`);
            }
        },

    },

};
</script>
