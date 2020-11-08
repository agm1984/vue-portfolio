<template>
    <div class="flex justify-center w-full h-auto">
        <a-card class="flex flex-col h-auto p-32 w-384">
            <a-heading level="1" class="mb-16 text-center">
                Login
            </a-heading>

            <div class="flex flex-col">
                <login-with-oauth provider="github"></login-with-oauth>
                <login-with-oauth provider="twitter" class="mt-8"></login-with-oauth>
            </div>

            <div class="flex items-center pt-16">
                <hr class="inline w-full">
                <span class="mx-8">or</span>
                <hr class="inline w-full">
            </div>

            <login-form></login-form>

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
