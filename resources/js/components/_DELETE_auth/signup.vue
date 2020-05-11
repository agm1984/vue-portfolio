<template>
    <a-page v-title="'Sign up'">
        <a-heading level="1">Sign up</a-heading>

        <a-form v-slot="{ handleSubmit }">
            <a-text-input
                v-model="fields.first_name"
                vid="first_name"
                rules="required|max:255"
                placeholder="First name"
                required
            ></a-text-input>

            <a-text-input
                v-model="fields.last_name"
                vid="last_name"
                rules="required|max:255"
                placeholder="Last name"
                required
            ></a-text-input>

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
                password-reveal
                required
            ></a-text-input>

            <a-button @click="handleSubmit(signup)">
                Sign up
            </a-button>
        </a-form>

    </a-page>
</template>

<script>
export default {
    name: 'signup',

    data() {
        return {
            fields: {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
            },
        };
    },

    computed: {},

    methods: {
        async signup() {
            try {
                console.log('fields', this.fields);
                const res = await axios.post('/api/signup', { ...this.fields });

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
