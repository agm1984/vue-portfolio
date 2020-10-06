<template>
    <a-card with-geometry>
        <div class="relative flex items-center justify-between">
            <a-heading level="1">
                {{ user.name }}
            </a-heading>
        </div>

        <a-card v-if="isShowing">
            <a-input-row type="is-split" heading="ID">
                <span>{{ user.id }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Status">
                <span>{{ user.status }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Slug">
                <span>{{ user.slug }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Name">
                <span>{{ user.name }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Created at">
                <span>{{ user.created_at }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Updated at">
                <span>{{ user.updated_at }}</span>
            </a-input-row>
        </a-card>

    </a-card>
</template>

<script>
import axios from 'axios';

const INITIAL = 'INITIAL';
const SHOWING = 'SHOWING';

export default {
    name: 'show-user',

    components: {},

    middleware: ['auth', 'role-admin'],

    data() {
        return {
            state: INITIAL,
            user: {},
        };
    },

    computed: {
        isInitializing() {
            return (this.state === INITIAL);
        },

        isShowing() {
            return (this.state === SHOWING);
        },

    },

    mounted() {
        return this.fetchUser();
    },

    methods: {
        async fetchUser() {
            try {
                const { data } = await axios.get(route('admin.users.show', this.$route.params.user));

                console.log('user', data.user);

                this.user = data.user;
                this.state = SHOWING;
            } catch (err) {
                throw new Error(`show-user# Problem fetching user: ${err}.`);
            }
        },

    },

};
</script>
