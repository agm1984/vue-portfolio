<script setup>
import { ref, computed, onMounted } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { useAuthStore } from '~/store/auth';


useHead({
    title: 'Admin Dashboard',
});

const currentRoute = useRoute();
const auth = useAuthStore();

const metrics = ref({});

const isDashboard = computed(() => currentRoute.name === 'admin');

const fetchMetrics = async () => {
    const response = await axios.get(route('admin.dashboard.metrics'));

    metrics.value = response.data;
};

onMounted(fetchMetrics);
</script>

<template>
    <div class="flex-1 flex w-full h-auto p-8">
        <div class="min-w-[125px] max-w-[125px] flex flex-col gap-4">
            <h1>Admin</h1>

            <router-link
                :to="{ name: 'admin' }"
                :class="['w-full inline-flex items-center font-semibold', {
                    'border-r-2 border-gray-900': isDashboard,
                }]"
            >Dashboard</router-link>

            <router-link
                :to="{ name: 'admin.users.list' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2 border-gray-900"
            >List Users</router-link>

            <router-link
                :to="{ name: 'admin.categories.list' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2 border-gray-900"
            >List Categories</router-link>

            <router-link
                v-if="auth.isAdmin"
                :to="{ name: 'admin.categories.create' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2 border-gray-900"
            >Add Category</router-link>

            <router-link
                :to="{ name: 'admin.examples.list' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2 border-gray-900"
            >List Examples</router-link>

            <router-link
                v-if="auth.isAdmin"
                :to="{ name: 'admin.examples.create' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2 border-gray-900"
            >Add Example</router-link>
        </div>

        <div class="w-full h-auto ml-8">
            <div v-if="isDashboard" class="w-full grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-2 sm:gap-4 md:gap-8">
                <a-card class="flex flex-col lg:flex-row lg:items-center lg:justify-between p-4 lg:p-8">
                    <h2>Categories</h2>
                    <span class="text-5xl">{{ metrics.categories_count }}</span>
                </a-card>

                <a-card class="flex flex-col lg:flex-row lg:items-center lg:justify-between p-4 lg:p-8">
                    <h2>Examples</h2>
                    <span class="text-5xl">{{ metrics.examples_count }}</span>
                </a-card>

                <a-card class="flex flex-col lg:flex-row lg:items-center lg:justify-between p-4 lg:p-8">
                    <h2>Users</h2>
                    <span class="text-5xl">{{ metrics.users_count }}</span>
                </a-card>
            </div>
            <a-card v-if="isDashboard" class="p-8 mt-8">
                <h2>Dashboard</h2>

                <div class="mt-2">
                    Welcome to the admin dashboard. Use the links on the left to manage categories, examples, and users.
                </div>

                <div v-if="auth.isAuthenticated && auth.isAdmin" class="mt-4">
                    You are logged in as <strong>{{ auth.user.name }}</strong> ({{ auth.user.email }}).
                </div>
                <div v-else class="flex gap-1 mt-4">
                    <span v-if="!auth.isAuthenticated">You are not logged in,</span>
                    <span v-else-if="auth.isAuthenticated">You are a Standard User,</span>
                    <span>so you cannot mutate any data, but you can have fun browsing the schema.</span>
                </div>

                <h2 class="mt-4">Metrics</h2>

                <div class="flex items-center gap-1 mt-2">
                    <span>Users signed up today:</span>
                    <strong>{{ metrics.users_signed_up_today }}</strong>
                </div>
            </a-card>

            <router-view v-else></router-view>
        </div>
    </div>
</template>
