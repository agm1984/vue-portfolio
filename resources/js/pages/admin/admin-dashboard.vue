<script setup>
import { ref, computed, onMounted } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '~/store/auth';
import { useAdminDashboardStore } from '~/store/adminDashboard';
import { useAdminUsersStore } from '~/store/adminUsers';
import { useAdminCategoriesStore } from '~/store/adminCategories';
import { useAdminExamplesStore } from '~/store/adminExamples';

useHead({
    title: 'Admin Dashboard',
});

const currentRoute = useRoute();
const auth = useAuthStore();
const adminDashboard = useAdminDashboardStore();
const adminUsers = useAdminUsersStore();
const adminCategories = useAdminCategoriesStore();
const adminExamples = useAdminExamplesStore();

const isDashboard = computed(() => currentRoute.name === 'admin');

const fetchMetrics = () => {
    if (Object.keys(adminDashboard.metrics).length === 0) {
        adminDashboard.getDashboardMetrics();
    }
};

onMounted(fetchMetrics);

const preloadHotPaths = () => {
    if (adminUsers.allUsers.length === 0) {
        adminUsers.getAllUsers();
    }

    if (adminCategories.allCategories.length === 0) {
        adminCategories.getAllCategories();
    }

    if (adminExamples.allExamples.length === 0) {
        adminExamples.getAllExamples();
    }
};

onMounted(preloadHotPaths);

const navItems = computed(() => [
    { label: 'Dashboard', route: 'admin', icon: 'pi pi-home', visible: true },
    { label: 'Users', route: 'admin.users.list', icon: 'pi pi-users', visible: true },
    { label: 'Categories', route: 'admin.categories.list', icon: 'pi pi-folder', visible: true },
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

                <dashboard-counts
                    :is-loading="adminDashboard.isFetchingMetrics"
                    :metrics="adminDashboard.metrics"
                ></dashboard-counts>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    <div class="space-y-8">
                        <dashboard-signups
                            :is-loading="adminDashboard.isFetchingMetrics"
                            :metrics="adminDashboard.metrics"
                        ></dashboard-signups>

                        <dashboard-growth
                            :is-loading="adminDashboard.isFetchingMetrics"
                            :metrics="adminDashboard.metrics"
                        ></dashboard-growth>
                    </div>

                    <dashboard-server-load
                        :is-loading="adminDashboard.isFetchingMetrics"
                        :metrics="adminDashboard.metrics"
                    ></dashboard-server-load>

                    <dashboard-usage
                        :is-loading="adminDashboard.isFetchingMetrics"
                        :metrics="adminDashboard.metrics"
                    ></dashboard-usage>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                     <div class="lg:col-span-2">
                        <dashboard-queue
                            :is-loading="adminDashboard.isFetchingMetrics"
                            :metrics="adminDashboard.metrics"
                        ></dashboard-queue>

                        <dashboard-env-specs
                            :is-loading="adminDashboard.isFetchingMetrics"
                            :metrics="adminDashboard.metrics"
                        ></dashboard-env-specs>
                    </div>

                    <dashboard-session></dashboard-session>
                </div>
            </template>

            <router-view v-else></router-view>
        </main>
    </div>
</template>
