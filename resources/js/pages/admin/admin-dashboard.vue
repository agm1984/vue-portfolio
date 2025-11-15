<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();

const isDashboard = computed(() => route.name === 'admin');
</script>

<template>
    <div class="flex-1 flex w-full h-auto p-8">
        <div class="min-w-[125px] max-w-[125px] flex flex-col gap-4">
            <h1>Admin</h1>

            <router-link
                :to="{ name: 'admin' }"
                :class="['w-full inline-flex items-center font-semibold', {
                    'border-r-2': isDashboard,
                }]"
                active-class=""
            >Dashboard</router-link>

            <router-link
                :to="{ name: 'admin.users.list' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2"
            >List Users</router-link>

            <router-link
                :to="{ name: 'admin.categories.list' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2"
            >List Categories</router-link>

            <router-link
                :to="{ name: 'admin.categories.create' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2"
            >Add Category</router-link>

            <router-link
                :to="{ name: 'admin.examples.list' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2"
            >List Examples</router-link>

            <router-link
                :to="{ name: 'admin.examples.create' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2"
            >Add Example</router-link>
        </div>

        <div class="w-full h-auto ml-8">
            <div v-if="isDashboard" class="w-full grid grid-cols-3 gap-8">
                <a-card class="flex flex-row items-center justify-between p-16">
                    <h2 level="2">
                        Categories
                    </h2>
                    <span class="text-5xl">8</span>
                </a-card>

                <a-card class="flex flex-row items-center justify-between p-16">
                    <h2 level="2">
                        Examples
                    </h2>
                    <span class="text-5xl">12</span>
                </a-card>

                <a-card class="flex flex-row items-center justify-between p-16">
                    <h2 level="2">
                        Users
                    </h2>
                    <span class="text-5xl">32</span>
                </a-card>
            </div>
            <a-card v-if="isDashboard" class="p-8 mt-8" with-geometry>
                <h2 level="2">
                    Dashboard
                </h2>

                <div>
                    <!-- <apexchart
                        type="line"
                        :options="options"
                        :series="series"
                    ></apexchart> -->
                </div>
            </a-card>

            <router-view v-else></router-view>
        </div>

        <!-- <div class="flex flex-col p-8">
            <h2 level="1">Categories</h2>

            <router-link :to="{ name: 'admin.categories.list' }" class="ml-16 nav-link-white">
                List categories
            </router-link>
            <router-link to="/admin/categories/create" class="ml-16 nav-link-white">Add category</router-link>
        </div>

        <div class="flex flex-col p-8">
            <h2 level="1">Examples</h2>

            <router-link :to="{ name: 'admin.examples.list' }" class="ml-16 nav-link-white">
                List examples
            </router-link>
            <router-link to="/admin/examples/create" class="ml-16 nav-link-white">Add example</router-link>
        </div>

        <div class="flex flex-col p-8">
            <h2 level="1">Users</h2>

            <router-link :to="{ name: 'admin.users.list' }" class="ml-16 nav-link-white">
                List users
            </router-link>
            <router-link to="/admin/users/create" class="ml-16 nav-link-white">Add user</router-link>
        </div> -->
    </div>
</template>
