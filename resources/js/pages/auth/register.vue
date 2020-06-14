<template>
    <div class="flex justify-center w-full h-auto">
        <a-card class="flex flex-col h-auto w-384">
            <span class="pb-32 text-2xl tracking-wide text-center text-white font-aroly">
                Register
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
                    v-model="newUser.name"
                    vid="name"
                    rules="required|max:255"
                    placeholder="Name"
                    required
                ></a-text-input>

                <a-text-input
                    v-model="newUser.email"
                    class="mt-8"
                    vid="email"
                    rules="required|email|max:255"
                    placeholder="Email"
                    required
                ></a-text-input>

                <a-text-input
                    v-model="newUser.password"
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
                    @click="handleSubmit(register)"
                >
                    Register
                </a-button>
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
        return { title: 'Register' };
    },

    data() {
        return {
            state: INITIAL,
            newUser: {
                email: '',
                password: '',
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
