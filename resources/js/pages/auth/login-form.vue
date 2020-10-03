<template>
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
</template>

<script>
const INITIAL = 'INITIAL';
const AUTHENTICATING = 'AUTHENTICATING';

export default {
    name: 'login-form',

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
            return (this.$store.getters['auth/intendedUrl'].length > 0);
        },

    },

    methods: {
        /**
         * Authenticates an existing user.
         *
         * @return {Function} Navigation event
         */
        async login() {
            try {
                this.state = AUTHENTICATING;

                await this.$store.dispatch('auth/login', this.credentials);

                if (this.hasIntendedUrl) {
                    return this.$router.push(this.$store.getters['auth/intendedUrl'])
                        .catch((err) => {
                            throw new Error(`login-form# Problem redirecting to intended URL: ${err}.`);
                        });
                }

                return this.$router.push({ name: 'home' }).catch((err) => {
                    throw new Error(`login-form# Problem navigating to 'home' route: ${err}.`);
                });
            } catch (err) {
                this.state = INITIAL;

                throw new Error(`login-form# Problem authenticating user: ${err}.`);
            }
        },

    },

};
</script>
