<template>
    <div class="flex w-full h-auto">

        <div class="sidebar-page">
            <section class="sidebar-layout">
                <b-sidebar
                    type="is-light"
                    mobile="reduce"
                    position="static"
                    expand-on-hover
                    open
                    reduce
                >
                    <div class="">
                        <div class="block">
                            <a-heading level="1">
                                Admin
                            </a-heading>
                        </div>
                        <b-menu class="is-custom-mobile">
                            <b-menu-list label="Users">
                                <b-menu-item
                                    label="List"
                                    tag="router-link"
                                    :to="{ name: 'admin.users.list' }"
                                    :active="$router.currentRoute.name === 'admin.users.list'"
                                ></b-menu-item>
                            </b-menu-list>

                            <b-menu-list label="Categories">
                                <b-menu-item
                                    label="List"
                                    tag="router-link"
                                    :to="{ name: 'admin.categories.list' }"
                                    :active="$router.currentRoute.name === 'admin.categories.list'"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Add"
                                    tag="router-link"
                                    :to="{ name: 'admin.categories.create' }"
                                    :active="$router.currentRoute.name === 'admin.categories.create'"
                                ></b-menu-item>
                            </b-menu-list>

                            <b-menu-list label="Examples">
                                <b-menu-item
                                    label="List"
                                    tag="router-link"
                                    :to="{ name: 'admin.examples.list' }"
                                    :active="$router.currentRoute.name === 'admin.examples.list'"
                                ></b-menu-item>
                                <!-- <b-menu-item
                                    label="Add"
                                    tag="router-link"
                                    :to="{ name: 'admin.examples.create' }"
                                    :active="$router.currentRoute.name === 'admin.examples.create'"
                                ></b-menu-item> -->
                            </b-menu-list>

                        </b-menu>
                    </div>
                </b-sidebar>
            </section>
        </div>

        <div class="w-full h-auto pt-64 pl-64">
            <router-view></router-view>
        </div>

        <!-- <div class="flex flex-col p-32">
            <a-heading level="1">Categories</a-heading>

            <router-link :to="{ name: 'admin.categories.list' }" class="ml-16 nav-link-white">
                List categories
            </router-link>
            <router-link to="/admin/categories/create" class="ml-16 nav-link-white">Add category</router-link>
        </div>

        <div class="flex flex-col p-32">
            <a-heading level="1">Examples</a-heading>

            <router-link :to="{ name: 'admin.examples.list' }" class="ml-16 nav-link-white">
                List examples
            </router-link>
            <router-link to="/admin/examples/create" class="ml-16 nav-link-white">Add example</router-link>
        </div>

        <div class="flex flex-col p-32">
            <a-heading level="1">Users</a-heading>

            <router-link :to="{ name: 'admin.users.list' }" class="ml-16 nav-link-white">
                List users
            </router-link>
            <router-link to="/admin/users/create" class="ml-16 nav-link-white">Add user</router-link>
        </div> -->
    </div>
</template>

<script>
export default {
    name: 'admin-dashboard',

    middleware: ['auth', 'role-admin'],

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
