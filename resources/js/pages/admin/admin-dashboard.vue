<template>
    <div>
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
    </div>
</template>

<script>
export default {
    name: 'admin-dashboard',

    metaInfo() {
        return { title: 'Dashboard' };
    },

    data() {
        return {};
    },

    computed: {},

    methods: {},

};
</script>
