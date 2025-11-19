<script setup>
import { ref, computed, onMounted } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

// PrimeVue Imports
import Knob from 'primevue/knob';
import ProgressBar from 'primevue/progressbar';
import Tag from 'primevue/tag';
import Message from 'primevue/message';

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

// --- Visual Logic ---
const getLoadColor = (load) => {
    if (load < 50) return 'var(--green-500)';
    if (load < 80) return 'var(--orange-500)';
    return 'var(--red-500)';
};

const serverLoadPercentage = computed(() => {
    const raw = metrics.value.system.server_load || 0;
    return Math.min(Math.round(raw * 100), 100);
});

const loadColor = computed(() => getLoadColor(serverLoadPercentage.value));

const growthRate = computed(() => metrics.value.activity.growth_rate || 0);
const isGrowthPositive = computed(() => growthRate.value >= 0);

const formattedMemory = computed(() => {
    const bytes = metrics.value.system.memory_usage_b;
    if (!bytes) return '0 MB';
    return (bytes / 1024 / 1024).toFixed(1) + ' MB';
});

const getSystemStatus = (failedJobs) => {
    if (failedJobs === 0) {
        return { severity: 'success', icon: 'pi pi-check-circle', text: 'All Systems Operational' };
    }
    if (failedJobs < 5) {
        return { severity: 'warn', icon: 'pi pi-exclamation-triangle', text: 'Minor Queue Issues Detected' };
    }
    return { severity: 'error', icon: 'pi pi-times-circle', text: 'Critical: Queue Failures Detected' };
};

const systemStatus = computed(() => getSystemStatus(metrics.value.activity.failed_jobs));

const dbQuotaPercentage = computed(() => {
    const size = metrics.value.system.database_size_mb || 0;
    const limit = 50; 
    return Math.min((size / limit) * 100, 100);
});

const statCards = computed(() => [
    {
        label: 'Total Users',
        value: metrics.value.counts.users,
        icon: 'pi pi-users',
        color: 'text-blue-500',
        bg: 'bg-blue-100 dark:bg-blue-900/30'
    },
    {
        label: 'Portfolio Examples',
        value: metrics.value.counts.examples,
        icon: 'pi pi-briefcase',
        color: 'text-purple-500',
        bg: 'bg-purple-100 dark:bg-purple-900/30'
    },
    {
        label: 'Categories',
        value: metrics.value.counts.categories,
        icon: 'pi pi-tags',
        color: 'text-emerald-500',
        bg: 'bg-emerald-100 dark:bg-emerald-900/30'
    },
]);

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

        <main class="flex-1 md:ml-64 p-4 md:p-8 max-w-7xl mx-auto w-full">
            
            <template v-if="isDashboard">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Welcome back! Here is what is happening with your portfolio.</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div 
                        v-for="stat in statCards"
                        :key="stat.label"
                        class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-5 hover:shadow-md transition-shadow duration-300"
                    >
                        <div :class="['p-4 rounded-xl flex items-center justify-center shadow-sm', stat.bg, stat.color]">
                            <i :class="['text-2xl', stat.icon]"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">{{ stat.label }}</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ stat.value }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <div class="space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 relative overflow-hidden">
                             <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-gray-500 font-medium mb-1">Signups Today</p>
                                    <span class="text-4xl font-bold text-gray-800 dark:text-white">
                                        {{ metrics.activity.users_today }}
                                    </span>
                                </div>
                                <div class="bg-green-50 dark:bg-green-900/20 p-2 rounded-lg">
                                    <i class="pi pi-user-plus text-xl text-green-600 dark:text-green-400"></i>
                                </div>
                            </div>
                        </div>
                         <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                            <p class="text-gray-500 font-medium mb-4">Monthly Growth</p>
                            <div class="flex items-center gap-4">
                                <span class="text-4xl font-bold" :class="isGrowthPositive ? 'text-green-500' : 'text-red-500'">
                                    {{ isGrowthPositive ? '+' : '' }}{{ growthRate }}%
                                </span>
                                <div class="px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 uppercase tracking-wide"
                                     :class="isGrowthPositive ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                                    <i :class="['pi', isGrowthPositive ? 'pi-arrow-up' : 'pi-arrow-down', 'text-xs']"></i>
                                    <span>{{ isGrowthPositive ? 'Trending Up' : 'Down' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex flex-col items-center justify-center text-center">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-6">Server Load</h3>
                        <Knob 
                            v-model="serverLoadPercentage" 
                            :size="140" 
                            readonly 
                            range-color="#f3f4f6" 
                            value-template="{value}%" 
                            :value-color="loadColor" 
                            :stroke-width="8" 
                        />
                        <p class="text-sm text-gray-400 mt-4">CPU Load Average (1 min)</p>
                    </div>

                     <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex flex-col justify-between">
                         <div class="mb-8">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-300 font-medium">Memory (RAM)</span>
                                <span class="font-mono font-bold text-indigo-600">{{ formattedMemory }}</span>
                            </div>
                            <ProgressBar 
                                :value="Math.min((metrics.system.memory_usage_b / 1024 / 1024 / 512) * 100, 100)" 
                                :showValue="false" 
                                class="h-3 rounded-full bg-gray-100 dark:bg-gray-700"
                                :pt="{ value: { class: 'bg-indigo-500 rounded-full' } }"
                            />
                            <p class="text-xs text-gray-400 mt-2 text-right">512MB Limit</p>
                        </div>

                        <div>
                            <div class="flex justify-between text-sm mb-2 font-medium">
                                <span class="text-gray-600 dark:text-gray-300">Database Storage</span>
                                <span class="text-purple-600">{{ metrics.system.database_size_mb }} MB</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-4 overflow-hidden relative">
                                <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-500 transition-all duration-1000"
                                     :style="{ width: `${dbQuotaPercentage < 5 ? 5 : dbQuotaPercentage}%` }">
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-2 text-right">InnoDB Engine</p>
                        </div>
                     </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                     <div class="lg:col-span-2">
                        <Message :severity="systemStatus.severity" :closable="false" class="w-full shadow-sm mb-6" :icon="systemStatus.icon">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                <span class="font-bold text-lg">{{ systemStatus.text }}</span>
                                <span v-if="metrics.activity.failed_jobs > 0" class="text-sm opacity-90">
                                    ({{ metrics.activity.failed_jobs }} failed jobs pending retry)
                                </span>
                                <span v-else class="text-sm opacity-90 ml-2">
                                    - Queue workers are processing normally.
                                </span>
                            </div>
                        </Message>

                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="pi pi-cog text-gray-400"></i> Environment Specs
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center gap-3">
                                        <i class="pi pi-desktop text-red-500 text-xl"></i>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Laravel</span>
                                    </div>
                                    <Tag :value="metrics.system.laravel_version" severity="danger" rounded class="px-3" />
                                </div>
                                <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center gap-3">
                                        <i class="pi pi-code text-blue-500 text-xl"></i>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">PHP</span>
                                    </div>
                                    <Tag :value="metrics.system.php_version" severity="info" rounded class="px-3" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-linear-to-br from-indigo-600 to-purple-700 rounded-xl p-6 text-white shadow-md flex flex-col justify-center">
                        <h3 class="text-xl font-bold mb-2">Admin Access</h3>
                        <p class="text-indigo-100 text-sm mb-6">
                            You are currently logged in with {{ auth.isAdmin ? 'full administrative' : 'standard' }} privileges.
                        </p>

                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                                <span class="font-mono text-sm">Session Active</span>
                            </div>
                            <div class="text-sm text-indigo-100">
                                <span class="font-bold">User:</span> {{ auth.user?.name }}
                            </div>
                            <div class="text-sm text-indigo-100 truncate">
                                <span class="font-bold">Email:</span> {{ auth.user?.email }}
                            </div>
                        </div>
                    </div>
                </div>

            </template>

            <div v-else class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 min-h-[500px]">
                <router-view></router-view>
            </div>
        </main>
    </div>
</template>
