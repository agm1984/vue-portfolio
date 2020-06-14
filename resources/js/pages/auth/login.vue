<template>
    <div class="flex justify-center w-full h-auto">
        <a-card class="flex flex-col h-auto w-384">
            <span class="pb-32 text-2xl tracking-wide text-center text-white font-aroly">
                Login
            </span>

            <div class="flex flex-col">
                <login-with-oauth provider="github"></login-with-oauth>
                <login-with-oauth provider="twitter" class="mt-8"></login-with-oauth>
            </div>

            <div class="flex items-center pt-16">
                <hr class="inline w-full">
                <span class="mx-8">or</span>
                <hr class="inline w-full">
            </div>

            <a-form v-slot="{ handleSubmit }" class="pt-16">
                <a-text-input
                    v-model="credentials.email"
                    vid="email"
                    rules="required|email|max:255"
                    placeholder="Email"
                    required
                ></a-text-input>

                <a-text-input
                    v-model="credentials.password"
                    class="mt-8"
                    type="password"
                    vid="password"
                    rules="required|min:8"
                    placeholder="Password"
                    password-reveal
                    required
                ></a-text-input>

                <a-button
                    class="mt-8"
                    :loading="isAuthenticating"
                    expanded
                    @click="handleSubmit(login)"
                >
                    Login
                </a-button>

                <div class="flex items-center justify-between pt-16">
                    <a-checkbox
                        v-model="credentials.remember"
                    >
                        Remember me
                    </a-checkbox>

                    <router-link :to="{ name: 'password.request' }">
                        Forgot password?
                    </router-link>
                </div>
            </a-form>

        </a-card>
    </div>
</template>

<script>
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
            credentials: {
                email: '',
                password: '',
                remember: true,
            },
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
            console.log('was unset');
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

                await this.$store.dispatch('auth/login', this.credentials);
                console.log('has intended 1', this.$store.getters['auth/intendedUrl'], 'a');

                if (this.hasIntendedUrl) {
                    console.log('has intended 2');
                    return this.$router.push(this.$store.getters['auth/intendedUrl'])
                        // .then(() => this.$store.dispatch('auth/clearIntendedUrl'))
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
