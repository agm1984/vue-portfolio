<script setup>
import { computed } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute } from 'vue-router';

useHead({
    title: 'Design System',
});

const currentRoute = useRoute();
const isDashboard = computed(() => currentRoute.name === 'design');

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
    {
        label: 'Forms',
        route: 'design.forms',
        icon: 'pi pi-check-square',
        description: 'Input fields, checkboxes, radio buttons, and selects.',
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
                    <h2 class="text-3xl font-semibold text-gray-900">System Overview</h2>
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
                        <a-card class="cursor-pointer group-hover:-translate-y-1 transform transition-transform p-8">
                            <div class="flex items-start gap-5 p-2">
                                <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center border group-hover:bg-pink-50 transition-colors duration-300">
                                    <i
                                        :class="[item.icon, 'text-2xl text-gray-500 group-hover:text-pink-500 transition-colors']"
                                        style="font-size: 24px;"
                                    ></i>
                                </div>

                                <div>
                                    <h3 class="group-hover:text-pink-600 transition-colors">
                                        {{ item.label }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                                        {{ item.description }}
                                    </p>
                                </div>
                            </div>
                        </a-card>
                    </router-link>
                </div>
            </template>

            <router-view v-else></router-view>
        </main>
    </div>
</template>
