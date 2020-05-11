<template>
    <div class="">
        <a-heading level="1">Login</a-heading>

        <a-form v-slot="{ handleSubmit }">
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
                <a-button @click="handleSubmit(login)">
                    Login
                </a-button>

                <login-with-oauth provider="github"></login-with-oauth>
                <login-with-oauth provider="twitter"></login-with-oauth>
            </div>
        </a-form>

    </div>
</template>

<script>
import Form from 'vform';
import LoginWithOauth from '~/components/login-with-oauth.vue';

export default {
    middleware: 'guest',

    components: {
        LoginWithOauth,
    },

    metaInfo() {
        return { title: 'Login' };
    },

    data() {
        return {
            fields: {
                email: '',
                password: '',
                remember: true,
            },
            form: new Form({
                email: '',
                password: '',
            }),
        };
    },

    methods: {
        async login() {
            const { data } = await this.form.post('/api/login');

            this.$store.dispatch('auth/saveToken', {
                token: data.token,
                remember: this.fields.remember,
            });

            await this.$store.dispatch('auth/fetchUser');

            this.$router.push({ name: 'home' });
        },

    },

};
</script>
