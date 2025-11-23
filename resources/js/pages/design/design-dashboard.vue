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
        colour: 'bg-red-100 text-red-700',
        icon: 'pi pi-stop',
        description: 'Primary, secondary, and ghost button interactions.',
        visible: true,
    },
    {
        label: 'Colours',
        route: 'design.colours',
        colour: 'bg-orange-100 text-orange-700',
        icon: 'pi pi-palette',
        description: 'Global color palette, gradients, and semantic tones.',
        visible: true,
    },
    {
        label: 'Space & Size',
        route: 'design.sizing',
        colour: 'bg-yellow-100 text-yellow-700',
        icon: 'pi pi-arrows-alt',
        description: 'Spacing scale, typography sizing, and breakpoints.',
        visible: true,
    },
    {
        label: 'Typography',
        route: 'design.typography',
        colour: 'bg-green-100 text-green-700',
        icon: 'pi pi-align-left',
        description: 'Headings, body text, and font weights.',
        visible: true,
    },
    {
        label: 'Forms',
        route: 'design.forms',
        colour: 'bg-teal-100 text-teal-700',
        icon: 'pi pi-check-square',
        description: 'Input fields, checkboxes, radio buttons, and selects.',
        visible: true,
    },
    {
        label: 'Feedback & Alerts',
        route: 'design.feedback',
        colour: 'bg-blue-100 text-blue-700',
        icon: 'pi pi-exclamation-circle',
        description: 'Modals, toasts, and loading indicators.',
        visible: true,
    },
    {
        label: 'Cards',
        route: 'design.cards',
        colour: 'bg-indigo-100 text-indigo-700',
        icon: 'pi pi-clone',
        description: 'Card layouts and content organization.',
        visible: true,
    },
    {
        label: 'Loading States',
        route: 'design.loading',
        colour: 'bg-purple-100 text-purple-700',
        icon: 'pi pi-spinner',
        description: 'Skeletons and spinners for loading content.',
        visible: true,
    },
];

const gridItems = computed(() => navItems.filter(item => item.route !== 'design'));
</script>

<template>
    <div class="flex-1 flex flex-col md:flex-row">
        <side-nav-pane
            :nav-items="navItems"
        ></side-nav-pane>

        <main class="flex-1 md:ml-64 p-8 max-w-7xl mx-auto w-full">
            <template v-if="isDashboard">
                <div>
                    <h1>Dashboard</h1>

                    <p class="text-gray-600 dark:text-gray-500 mt-2">
                        A centralized registry of UI components, design tokens, and usage guidelines.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-4">
                    <router-link
                        v-for="item in gridItems"
                        :key="`design-system-section-${item.route}`"
                        :to="{ name: item.route }"
                        class="block group"
                    >
                        <a-card class="cursor-pointer group-hover:-translate-y-1 transform transition-transform p-8">
                            <div class="flex items-start gap-5 p-2">
                                <div :class="['min-w-16 w-16 min-h-16 h-16 rounded-full flex items-center justify-center border', item.colour]">
                                    <i
                                        :class="['', item.icon]"
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
