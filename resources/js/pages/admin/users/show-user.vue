<template>
    <a-card class="p-32" with-geometry>
        <div class="relative flex items-center mb-16">
            <a-avatar :size="64" :user.sync="user"></a-avatar>
            <h2 level="2" class="ml-8">
                {{ user.name }}
            </h2>
        </div>

        <div v-if="isShowing">
            <a-input-row type="is-wider-right" heading="ID">
                <span>{{ user.id }}</span>
            </a-input-row>

            <a-input-row class="pt-8" type="is-wider-right" heading="Status">
                <span>{{ user.status }}</span>
            </a-input-row>

            <a-input-row class="pt-8" type="is-wider-right" heading="Name">
                <span>{{ user.name }}</span>
            </a-input-row>

            <a-input-row class="pt-8" type="is-wider-right" heading="Email">
                <span>{{ user.email }}</span>
            </a-input-row>

            <a-input-row class="pt-8" type="is-wider-right" heading="Created at">
                <span>{{ user.created_at_nice }} ({{ user.created_at_diff }})</span>
            </a-input-row>

            <a-input-row class="pt-8" type="is-wider-right" heading="Updated at">
                <span>{{ user.updated_at_nice }} ({{ user.updated_at_diff }})</span>
            </a-input-row>
        </div>

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
