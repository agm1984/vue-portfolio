<script setup>
import { ref, computed, watch } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

// PrimeVue Imports
import Button from 'primevue/button';
import Tag from 'primevue/tag';
import Skeleton from 'primevue/skeleton'; // For a pro loading state

useHead({
    title: 'Examples',
});

const currentRoute = useRoute();

// --- STATE MACHINE CONSTANTS ---
const LOADING = 'is-loading';
const LOADED = 'is-loaded';
const HAS_ERROR = 'is-error';

// --- REACTIVE STATE ---
const state = ref(LOADING);
const categories = ref([]);
const examples = ref([]);

// --- COMPUTED HELPERS ---
const isLoading = computed(() => state.value === LOADING);
const isLoaded = computed(() => state.value === LOADED);
const hasError = computed(() => state.value === HAS_ERROR);
const hasExamples = computed(() => examples.value.length > 0);

const activeCategory = computed(() => currentRoute.params.category || null);

// --- SIDE EFFECTS ---
const fetchAllExamples = async () => {
    try {
        state.value = LOADING;

        const [categoriesRes, examplesRes] = await Promise.all([
            axios.get(route('public.categories.list')),
            axios.get(route('public.examples.list'), {
                params: {
                    'filter[category.slug]': currentRoute.params.category,
                },
            }),
        ]);

        categories.value = categoriesRes.data.categories;
        examples.value = examplesRes.data.examples;
        state.value = LOADED;
    } catch (err) {
        state.value = HAS_ERROR;
        console.error('list-examples# Problem fetching data:', err);
    }
}

const handleTryAgain = () => {
    fetchAllExamples();
}

watch(() => currentRoute.fullPath, fetchAllExamples, { immediate: true });
</script>

<template>
    <div class="w-full max-w-7xl mx-auto flex flex-col p-6 md:p-12 min-h-screen">
        <div class="flex flex-col gap-8 mb-10">
            <div>
                <h1>Examples</h1>
                <p class="text-gray-500 mt-2">
                    A collection of code snippets, full projects, experiments and learning.
                </p>
            </div>

            <div class="flex flex-wrap gap-2 pb-2 overflow-x-auto no-scrollbar">
                <router-link
                    :to="{ name: 'public.examples.list' }"
                    class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-200 border"
                    :class="[
                        !activeCategory
                            ? 'bg-indigo-600 text-white border-indigo-600 shadow-md'
                            : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:border-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700'
                    ]"
                >
                    All Projects
                </router-link>

                <router-link
                    v-for="category in categories"
                    :key="`catagory-${category.slug}`"
                    :to="{ name: 'public.examples.list', params: { category: category.slug } }"
                    class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-200 border whitespace-nowrap"
                    :class="[
                        activeCategory === category.slug
                            ? 'bg-indigo-600 text-white border-indigo-600 shadow-md'
                            : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:border-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700'
                    ]"
                >
                    {{ category.name }}
                </router-link>
            </div>
        </div>

        <div v-if="isLoading" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            <div v-for="n in 6" :key="n" class="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <Skeleton height="200px" width="100%"></Skeleton>
                <div class="p-4">
                    <Skeleton width="60%" height="1.5rem" class="mb-2"></Skeleton>
                    <Skeleton width="30%" height="1rem"></Skeleton>
                </div>
            </div>
        </div>

        <div v-else-if="isLoaded && hasExamples">
            <TransitionGroup 
                name="list" 
                tag="div" 
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8"
            >
                <router-link
                    v-for="example in examples"
                    :key="example.slug"
                    :to="{ name: 'public.examples.show', params: { category: example.category.slug, example: example.slug } }"
                    class="group flex flex-col bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-full"
                >
                    <div class="relative aspect-video w-full overflow-hidden bg-gray-100 dark:bg-gray-900">
                        
                        <template v-if="example.images?.length > 0">
                            <a-tilt class="w-full h-full">
                                <a-image
                                    :src="`/storage/examples/${example.slug}/${example.images?.[0]?.filename}`"
                                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
                                    background="#f3f4f6"
                                    alt="Example image"
                                />
                            </a-tilt>
                        </template>

                        <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900 group-hover:from-indigo-900 group-hover:to-purple-900 transition-colors duration-500">
                            <div class="text-center opacity-50">
                                <i class="pi pi-code text-5xl text-white mb-2"></i>
                                <div class="font-mono text-xs text-gray-400">&lt;code /&gt;</div>
                            </div>
                        </div>

                        <div class="absolute top-3 right-3">
                             <Tag :value="example.category.name" rounded class="!bg-white/90 !text-gray-800 backdrop-blur-sm border border-gray-200 shadow-sm font-bold text-xs uppercase tracking-wider" />
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-1">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-indigo-600 transition-colors">
                            {{ example.name }}
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2">
                            Click to view project details, code snippets, and live demos.
                        </p>
                        
                        <div class="mt-auto pt-4 flex items-center text-indigo-600 font-semibold text-sm">
                            <span>View</span>
                            <i class="pi pi-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                        </div>
                    </div>
                </router-link>
            </TransitionGroup>
        </div>

        <a-card v-else-if="isLoaded && !hasExamples" class="p-12 mt-8 text-center">
            <div class="flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="pi pi-search text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">No examples found</h3>
                <p class="text-gray-500 mt-2">
                    We couldn't find any projects in the <strong>{{ activeCategory }}</strong> category.
                </p>
                <Button 
                    label="View All Projects" 
                    text 
                    class="mt-4" 
                    @click="$router.push({ name: 'public.examples.list' })" 
                />
            </div>
        </a-card>

        <div v-else-if="hasError" class="w-full mt-12 flex flex-col items-center justify-center text-center">
            <i class="pi pi-exclamation-circle text-4xl text-red-500 mb-4"></i>
            <h3 class="text-lg font-bold text-gray-900">Something went wrong</h3>
            <p class="text-gray-500 mb-6">We failed to load the project examples.</p>
            <Button
                type="button"
                severity="danger"
                icon="pi pi-refresh"
                label="Try again"
                @click="handleTryAgain"
            />
        </div>

    </div>
</template>

<style scoped>
/* Smooth Transition for Filtering */
.list-move,
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateY(30px);
}

.list-leave-active {
  position: absolute;
}

/* Hide scrollbar for the filter pills */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
