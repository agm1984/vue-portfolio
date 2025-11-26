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

const metrics = ref({
    counts: { users: 0, examples: 0, categories: 0 },
    system: { server_load: 0, memory_usage_b: 0, database_size_mb: 0, laravel_version: '', php_version: '' },
    activity: { failed_jobs: 0, growth_rate: 0, users_today: 0 },
});

const isDashboard = computed(() => currentRoute.name === 'admin');

const fetchMetrics = async () => {
    try {
        const response = await axios.get(route('admin.dashboard.metrics'));
        metrics.value = response.data;
    } catch (e) {
        console.error("Failed to load metrics", e);
    }
};

onMounted(fetchMetrics);

const navItems = computed(() => [
    { label: 'Dashboard', route: 'admin', icon: 'pi pi-home', visible: true },
    { label: 'Users', route: 'admin.users.list', icon: 'pi pi-users', visible: true },
    { label: 'Categories', route: 'admin.categories.list', icon: 'pi pi-tags', visible: true },
    { label: 'Add Category', route: 'admin.categories.create', icon: 'pi pi-plus', visible: auth.isAdmin },
    { label: 'Examples', route: 'admin.examples.list', icon: 'pi pi-briefcase', visible: true },
    { label: 'Add Example', route: 'admin.examples.create', icon: 'pi pi-plus-circle', visible: auth.isAdmin },
]);
</script>

<template>
    <div class="flex-1 flex flex-col md:flex-row">
        <side-nav-pane
            :nav-items="navItems"
        ></side-nav-pane>

        <main class="flex-1 w-full md:ml-64 p-4 md:p-8">
            <template v-if="isDashboard">
                <a-page-title
                    title="Dashboard"
                    description="Overview of site metrics and activity."
                ></a-page-title>

                <dashboard-counts :metrics="metrics"></dashboard-counts>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    <div class="space-y-8">
                        <dashboard-signups :metrics="metrics"></dashboard-signups>

                        <dashboard-growth :metrics="metrics"></dashboard-growth>
                    </div>

                    <dashboard-server-load :metrics="metrics"></dashboard-server-load>

                    <dashboard-usage :metrics="metrics"></dashboard-usage>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                     <div class="lg:col-span-2">
                        <dashboard-queue :metrics="metrics"></dashboard-queue>

                        <dashboard-env-specs :metrics="metrics"></dashboard-env-specs>
                    </div>

                    <dashboard-session></dashboard-session>
                </div>
            </template>

            <router-view v-else></router-view>
        </main>
    </div>
</template>
