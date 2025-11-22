<script setup>
import { computed } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute } from 'vue-router';
import Card from 'primevue/card'; // Assuming PrimeVue is available

useHead({
    title: 'Design System',
});

const currentRoute = useRoute();
const isDashboard = computed(() => currentRoute.name === 'design');

// 1. Single Source of Truth for Navigation (Functional Data Structure)
// We use this to generate the Sidebar AND the Dashboard Grid cards.
const navItems = [
    {
        label: 'Dashboard',
        route: 'design',
        icon: 'pi pi-home',
        description: 'Overview of the design system components.',
        visible: true,
    },
    {
        label: 'Buttons',
        route: 'design.buttons',
        icon: 'pi pi-stop',
        description: 'Primary, secondary, and ghost button interactions.',
        visible: true,
    },
    {
        label: 'Colours',
        route: 'design.colours',
        icon: 'pi pi-palette',
        description: 'Global color palette, gradients, and semantic tones.',
        visible: true,
    },
    {
        label: 'Space & Size',
        route: 'design.sizing',
        icon: 'pi pi-arrows-alt',
        description: 'Spacing scale, typography sizing, and breakpoints.',
        visible: true,
    },
    {
        label: 'Typography',
        route: 'design.typography',
        icon: 'pi pi-align-left',
        description: 'Headings, body text, and font weights.',
        visible: true,
    },
];

// 2. Filter out 'Dashboard' for the grid view (Pure transformation)
const gridItems = computed(() => navItems.filter(item => item.route !== 'design'));
</script>

<template>
    <div class="flex-1 flex flex-col md:flex-row">
        <side-nav-pane
            :nav-items="navItems"
        ></side-nav-pane>

        <main class="flex-1 md:ml-64 p-8 max-w-7xl mx-auto w-full">
            
            <template v-if="isDashboard">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">System Overview</h2>
                    <p class="text-gray-600 dark:text-gray-500 mt-2">
                        A centralized registry of UI components, design tokens, and usage guidelines.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <router-link 
                        v-for="item in gridItems" 
                        :key="item.route" 
                        :to="{ name: item.route }"
                        class="block group"
                    >
                        <Card class="h-full shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 dark:border-gray-700 cursor-pointer group-hover:-translate-y-1 transform transition-transform">
                            <template #content>
                                <div class="flex items-start gap-5 p-2">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center border border-gray-100 dark:border-gray-600 group-hover:bg-pink-50 dark:group-hover:bg-pink-900/20 transition-colors duration-300">
                                        <i :class="[item.icon, 'text-2xl text-gray-500 group-hover:text-pink-500 transition-colors']"></i>
                                    </div>
                                    
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-pink-600 transition-colors">
                                            {{ item.label }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-500 mt-2 leading-relaxed">
                                            {{ item.description }}
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </Card>
                    </router-link>
                </div>
            </template>

            <div v-else class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 min-h-[80vh]">
                <router-view></router-view>
            </div>

        </main>
    </div>
</template>
