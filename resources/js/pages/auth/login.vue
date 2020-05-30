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

            <div class="flex justify-between">
                <div>
                    <router-link :to="{ name: 'password.request' }" class="my-auto ml-auto small">
                        Forgot password?
                    </router-link>
                </div>

                <div class="flex flex-col items-end">
                    <a-button :loading="isAuthenticating" @click="handleSubmit(login)">
                        Login
                    </a-button>

                    <login-with-oauth provider="github"></login-with-oauth>
                    <login-with-oauth provider="twitter"></login-with-oauth>
                </div>
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

        hasIntendedUrl() {
            return (this.$store.getters['auth/intendedUrl'].length > 0);
        },

    },

    created() {
        if (this.$store.getters['auth/intendedUrl']) {
            this.$router.replace({ name: 'login', query: { redirect: this.$store.getters['auth/intendedUrl'] } });
        }
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

                if (this.hasIntendedUrl) {
                    return this.$router.push(this.$store.getters['auth/intendedUrl'])
                        .then(() => this.$store.dispatch('auth/clearIntendedUrl'))
                        .catch((err) => {
                            throw new Error(`login# Problem redirecting to intended URL: ${err}.`);
                        });
                }

                return this.$router.push({ name: 'home' }).catch(() => {
                    throw new Error(`login# Problem navigating to 'home' route: ${err}.`);
                });
            } catch (err) {
                this.state = INITIAL;

                throw new Error(`login# Problem authenticating user: ${err}.`);
            }
        },

    },

};
</script>
