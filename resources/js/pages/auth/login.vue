<template>
    <div class="flex justify-center w-full h-auto">
        <a-card class="flex flex-col h-auto w-384">
            <span class="pb-32 text-2xl text-center text-white font-aroly">
                Login
            </span>

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

                <a-button :loading="isAuthenticating" expanded @click="handleSubmit(login)">
                    Login
                </a-button>

                <div class="flex justify-center pt-16">
                    <router-link :to="{ name: 'password.request' }">
                        Forgot password?
                    </router-link>
                </div>

                <hr>

                <div class="flex items-center justify-around">
                    <login-with-oauth provider="github"></login-with-oauth>
                    <login-with-oauth provider="twitter"></login-with-oauth>
                </div>

            </a-form>

        </a-card>
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
