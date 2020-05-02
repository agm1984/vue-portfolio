<template>
    <a-page v-title="'Admin'">

        <div class="flex flex-col p-32">
            <a-heading level="1">Categories</a-heading>

            <router-link to="/admin/categories" class="ml-16 nav-link-white">List categories</router-link>
            <router-link to="/admin/examples" class="ml-16 nav-link-white">List examples</router-link>
        </div>

    </a-page>
</template>

<script>
export default {
    name: 'admin-dashboard',

    props: {},

    data() {
        return {};
    },

    computed: {},

    mounted() {},

    methods: {},

};
</script>
