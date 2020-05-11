<template>
    <a-page v-title="'Login'">
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

            <a-button @click="handleSubmit(login)">
                Login
            </a-button>
        </a-form>

        <p v-if="error" class="mt-6 text-xs italic text-red-500" role="alert">{{ error }}</p>

        <p
            v-if="loading && !error"
            class="mt-6 text-xs italic text-blue-500"
            role="alert"
        >
            Loading...
        </p>

    </a-page>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';

export default {
    name: 'login',

    data() {
        return {
            fields: {
                email: '',
                password: '',
                device_name: 'web',
            },
        };
    },

    computed: {
        ...mapGetters('auth', ['authUser', 'error', 'loading']),
    },

    mounted() {
        // axios.get('/sanctum/csrf-cookie');
        // axios.post('/login', { email: 'adam@test.com', password: 'password' });
    },

    methods: {
        // login() {
        //     return this.$store.dispatch('auth/login', this.$data.fields).then(() => {
        //         this.$router.push(this.$route.query.redirect || '/');
        //     });
        // },

        async login() {
            try {
                console.log('fields', this.fields);
                const res = await axios.post('/api/login', this.fields);

                console.log('res', res);
            } catch (err) {
                console.log('err', err.message);
                console.log('err', err.data);
                console.log('err', err.response);
                throw new Error(`signup# Problem signing up new user: ${err}.`);
            }
        },
    },

};
</script>
