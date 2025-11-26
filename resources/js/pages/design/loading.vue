<script setup>
import { ref } from 'vue';
import { useHead } from '@unhead/vue';
import Card from 'primevue/card';
import Button from 'primevue/button';
import ProgressSpinner from 'primevue/progressspinner';
import Skeleton from 'primevue/skeleton';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Avatar from 'primevue/avatar';

useHead({
    title: 'Design System Loading',
});

const demoState = ref('loaded'); // 'loaded', 'skeleton', 'spinner'

const demoUser = {
    name: 'Adam Mackintosh',
    handle: '@agm1984',
    role: 'Code Wizard',
    bio: 'Building scalable architectures with Laravel, Vue 3, and Functional Programming principles.',
    projects: 42,
    followers: 1337,
};

const products = ref(new Array(4).fill({})); // Dummy array for skeleton rows
</script>

<template>
    <div class="w-full flex flex-col transition-colors duration-300">
        <a-page-title
            title="Loading States"
            description="Patterns to manage wait times, reduce perceived latency, and prevent layout shifts."
            has-back
            @on-back="goBack"
        ></a-page-title>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-l-4 border-indigo-500 border-y border-r dark:border-gray-700 p-8 transition-colors duration-300">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-gray-900 dark:text-white">UX Playground</h3>
                    <p class="max-w-sm text-sm text-gray-500 dark:text-gray-400 font-normal mt-1">
                        Use the buttons to compare how different loading strategies affect the UI feel.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <Button label="Show Data" icon="pi pi-check" size="small" :severity="demoState === 'loaded' ? 'primary' : 'secondary'" @click="demoState = 'loaded'" />
                    <Button label="Skeleton" icon="pi pi-bars" size="small" :severity="demoState === 'skeleton' ? 'primary' : 'secondary'" @click="demoState = 'skeleton'" />
                    <Button label="Spinner" icon="pi pi-spinner" size="small" :severity="demoState === 'spinner' ? 'primary' : 'secondary'" @click="demoState = 'spinner'" />
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mt-8">
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8 min-h-[300px] relative overflow-hidden transition-colors">
                    
                    <div v-if="demoState === 'spinner'" class="absolute inset-0 flex flex-col items-center justify-center bg-white/80 dark:bg-gray-900/80 z-10 backdrop-blur-sm transition-colors">
                        <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="4" />
                        <span class="text-xs font-bold uppercase text-gray-400 mt-4 animate-pulse">Fetching User...</span>
                    </div>

                    <div v-if="demoState === 'skeleton'" class="space-y-6 animate-pulse">
                        <div class="flex items-center gap-4">
                            <Skeleton shape="circle" size="4rem" />
                            <div class="flex-1">
                                <Skeleton width="60%" height="1.5rem" class="mb-2" />
                                <Skeleton width="40%" height="1rem" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Skeleton width="100%" height="1rem" />
                            <Skeleton width="90%" height="1rem" />
                            <Skeleton width="95%" height="1rem" />
                        </div>
                        <div class="flex gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <Skeleton width="5rem" height="2rem" borderRadius="2rem" />
                            <Skeleton width="5rem" height="2rem" borderRadius="2rem" />
                        </div>
                    </div>

                    <div v-else-if="demoState === 'loaded'" class="space-y-6">
                        <div class="flex items-center gap-4">
                            <Avatar image="/adam.png" size="xlarge" shape="circle" class="border-2 border-indigo-100 dark:border-indigo-900" />
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ demoUser.name }}</h4>
                                <p class="text-indigo-600 dark:text-indigo-400 font-mono text-sm">{{ demoUser.handle }}</p>
                            </div>
                        </div>

                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            {{ demoUser.bio }}
                        </p>

                        <div class="flex gap-4 pt-4 border-t border-gray-100 dark:border-gray-700 transition-colors">
                            <div class="text-center">
                                <span class="block font-bold text-xl text-gray-900 dark:text-white">{{ demoUser.projects }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 uppercase">Projects</span>
                            </div>
                            <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                            <div class="text-center">
                                <span class="block font-bold text-xl text-gray-900 dark:text-white">{{ demoUser.followers }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 uppercase">Followers</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-center space-y-6">
                    <div class="flex gap-4">
                        <div class="p-3 bg-gray-100 dark:bg-gray-800 rounded-lg h-fit transition-colors">
                            <i class="pi pi-table text-xl text-gray-500 dark:text-gray-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">When to use Skeletons</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Use when loading initial content (like a profile or list). It preserves layout height and prevents <strong class="text-indigo-600 dark:text-indigo-400">Cumulative Layout Shift (CLS)</strong>.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="p-3 bg-gray-100 dark:bg-gray-800 rounded-lg h-fit transition-colors">
                            <i class="pi pi-spinner text-xl text-gray-500 dark:text-gray-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">When to use Spinners</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Use for blocking actions (e.g., "Submitting Form") or when the layout dimensions are unknown (e.g., "Loading Image").
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 h-full transition-colors duration-300">
                <h3 class="text-gray-900 dark:text-white">Primitives</h3>
                <div class="space-y-6 mt-4">
                    <div class="space-y-2">
                        <span class="text-xs font-bold uppercase text-gray-400">Text Lines</span>
                        <Skeleton class="mb-2" />
                        <Skeleton width="75%" />
                    </div>
                    <div class="space-y-2">
                        <span class="text-xs font-bold uppercase text-gray-400">Shapes</span>
                        <div class="flex gap-4">
                            <Skeleton shape="circle" size="4rem" />
                            <Skeleton width="4rem" height="4rem" />
                            <Skeleton width="8rem" height="4rem" borderRadius="16px" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 h-full transition-colors duration-300">
                <h3 class="text-gray-900 dark:text-white">Data Lists</h3>
                <div class="mt-4">
                    <p class="text-xs font-bold uppercase text-gray-400 mb-2">Table Rows</p>
                    <div class="border dark:border-gray-700 rounded-lg overflow-hidden">
                        <DataTable :value="products" class="p-datatable-sm">
                            <Column header="Name">
                                <template #body><Skeleton /></template>
                            </Column>
                            <Column header="Category">
                                <template #body><Skeleton width="60%" /></template>
                            </Column>
                            <Column header="Status">
                                <template #body><Skeleton width="40%" height="1.5rem" borderRadius="1rem" /></template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 mt-8 transition-colors duration-300">
            <h3 class="text-gray-900 dark:text-white">Indeterminate Spinners</h3>
            <div class="flex flex-wrap items-center gap-12 mt-4">
                <div class="text-center">
                    <ProgressSpinner style="width: 30px; height: 30px" strokeWidth="5" />
                    <p class="text-xs text-gray-400 mt-2">Small (30px)</p>
                </div>

                <div class="text-center">
                    <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="4" />
                    <p class="text-xs text-gray-400 mt-2">Default (50px)</p>
                </div>

                <div class="text-center">
                    <ProgressSpinner style="width: 80px; height: 80px" strokeWidth="3" />
                    <p class="text-xs text-gray-400 mt-2">Large (80px)</p>
                </div>

                <div class="text-center bg-gray-900 p-6 rounded-xl">
                    <ProgressSpinner
                        style="width: 50px; height: 50px"
                        strokeWidth="4"
                        fill="transparent"
                        animationDuration=".5s"
                        aria-label="Custom Spinner"
                    />
                    <p class="text-xs text-gray-400 mt-2">Dark Mode</p>
                </div>
            </div>
        </div>
    </div>
</template>
