<template>
    <div class="">
        <a-heading level="1">Login</a-heading>

        <a-form v-slot="{ handleSubmit }">
            <a-text-input
                v-model="user.email"
                vid="email"
                rules="required|email|max:255"
                placeholder="Email"
                required
            ></a-text-input>

            <a-text-input
                v-model="user.password"
                vid="password"
                rules="required|min:8"
                placeholder="Password"
                type="password"
                required
            ></a-text-input>

            <div class="flex items-center">
                <checkbox v-model="user.remember" name="remember">
                    Remember me
                </checkbox>

                <router-link :to="{ name: 'password.request' }" class="my-auto ml-auto small">
                    Forgot password?
                </router-link>
            </div>

            <div class="flex flex-col">
                <a-button :loading="isAuthenticating" @click="handleSubmit(login)">
                    Login
                </a-button>

                <login-with-oauth provider="github" :intended-url="intendedUrl"></login-with-oauth>
                <login-with-oauth provider="twitter" :intended-url="intendedUrl"></login-with-oauth>
            </div>
        </a-form>

    </div>
</template>

<script>
import Form from 'vform';
import LoginWithOauth from '~/components/login-with-oauth.vue';

const INITIAL = 'INITIAL';
const AUTHENTICATING = 'AUTHENTICATING';

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
            state: INITIAL,
            user: {
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

    computed: {
        isInitial() {
            return (this.state === INITIAL);
        },

        isAuthenticating() {
            return (this.state === AUTHENTICATING);
        },

        intendedUrl() {
            return this.$route.query.redirect;
        },

    },

    methods: {
        /**
         * Authenticate an existing user.
         *
         * @return {Function} Navigation event
         */
        async login() {
            try {
                this.state = AUTHENTICATING;

                await this.$store.dispatch('auth/login', this.user);

                if (this.intendedUrl) {
                    return this.$router.push(this.intendedUrl);
                }

                return this.$router.push({ name: 'home' });
            } catch (err) {
                this.state = INITIAL;

                throw new Error(`login# Problem authenticating user: ${err}.`);
            }
        },

    },

};
</script>
