<template>
    <div class="">
        <a-heading level="1">Register</a-heading>

        <a-form v-slot="{ handleSubmit }">
            <a-text-input
                v-model="newUser.name"
                vid="name"
                rules="required|max:255"
                placeholder="Name"
                required
            ></a-text-input>

            <a-text-input
                v-model="newUser.email"
                vid="email"
                rules="required|email|max:255"
                placeholder="Email"
                required
            ></a-text-input>

            <a-text-input
                v-model="newUser.password"
                vid="password"
                rules="required|min:8"
                placeholder="Password"
                type="password"
                required
            ></a-text-input>

            <div class="flex items-center">
                <checkbox v-model="newUser.remember" name="remember">
                    Remember me
                </checkbox>

                <router-link :to="{ name: 'password.request' }" class="my-auto ml-auto small">
                    Forgot password?
                </router-link>
            </div>

            <div class="flex flex-col">
                <a-button :loading="isAuthenticating" @click="handleSubmit(register)">
                    Register
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
        return { title: 'Register' };
    },

    data() {
        return {
            state: INITIAL,
            newUser: {
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
         * Register a new user.
         *
         * @return {Function} Navigation event
         */
        async register() {
            try {
                this.state = AUTHENTICATING;

                await this.$store.dispatch('auth/register', this.newUser);

                if (this.intendedUrl) {
                    return this.$router.push(this.intendedUrl);
                }

                return this.$router.push({ name: 'home' });
            } catch (err) {
                this.state = INITIAL;

                throw new Error(`register# Problem registering new user: ${err}.`);
            }
        },

    },

};
</script>
