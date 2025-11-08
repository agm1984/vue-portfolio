<template>
    <div class="flex justify-center w-full h-auto">
        <a-card class="flex flex-col h-auto p-32 w-384">
            <h1>Login</h1>

            <div class="flex flex-col">
                <!-- <login-with-oauth provider="github"></login-with-oauth> -->
                <!-- <login-with-oauth provider="twitter" class="mt-8"></login-with-oauth> -->
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

                    <!-- <router-link :to="{ name: 'password.request' }">
                        Forgot password?
                    </router-link> -->
                </div>
            </a-form>

        </a-card>
    </div>
</template>

<script>
import LoginWithOauth from '~/components/login-with-oauth.vue';
import LoginForm from './login-form.vue';

export default {
    middleware: 'guest',

    components: {
        LoginWithOauth,
        LoginForm,
    },

    metaInfo() {
        return { title: 'Login' };
    },

    data() {
        return {};
    },

    computed: {
        hasIntendedUrl() {
            return (this.$store.getters['auth/intendedUrl'].length > 0);
        },

    },

    created() {
        if (this.$store.getters['auth/intendedUrl']) {
            this.$router.replace({ name: 'login', query: { redirect: this.$store.getters['auth/intendedUrl'] } });
        }
    },

    methods: {},

};
</script>
