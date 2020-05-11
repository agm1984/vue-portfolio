<template>
    <a-page v-title="'Admin'">

        <div class="flex flex-col p-32">
            <a-heading level="1">Categories</a-heading>

            <router-link to="/admin/categories" class="ml-16 nav-link-white">List categories</router-link>
            <router-link to="/admin/categories/create" class="ml-16 nav-link-white">Add category</router-link>
        </div>

        <div class="flex flex-col p-32">
            <a-heading level="1">Examples</a-heading>

            <router-link to="/admin/examples" class="ml-16 nav-link-white">List examples</router-link>
            <router-link to="/admin/examples/create" class="ml-16 nav-link-white">Add example</router-link>
        </div>

        <div class="flex flex-col p-32">
            <a-heading level="1">Users</a-heading>

            <router-link to="/admin/users" class="ml-16 nav-link-white">List users</router-link>
            <router-link to="/admin/users/create" class="ml-16 nav-link-white">Add user</router-link>
        </div>

        authUser: {{ authUser }}<br>

        loggedIn: {{ loggedIn }}<br>

        <a-button @click="logout">
            Log out
        </a-button>

    </a-page>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: 'admin-dashboard',

    props: {},

    data() {
        return {};
    },

    computed: {
        ...mapGetters('auth', ['authUser', 'loggedIn']),
    },

    mounted() {},

    methods: {
        logout() {
            this.$store.dispatch('auth/logout');
        },
    },

};
</script>
