<script setup>
import { ref, computed, onMounted } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import Button from 'primevue/button';
import Tag from 'primevue/tag';
import Skeleton from 'primevue/skeleton';

useHead({
    title: 'Examples',
});

const currentRoute = useRoute();
const router = useRouter();

const LOADING = 'is-loading';
const LOADED = 'is-loaded';
const HAS_ERROR = 'is-error';
const isLoading = computed(() => state.value === LOADING);
const isLoaded = computed(() => state.value === LOADED);
const hasError = computed(() => state.value === HAS_ERROR);
const state = ref(LOADING);
const categories = ref([]);
const examples = ref([]);
const activeCategory = ref('all');
const searchTerms = ref('');

const fetchCategories = async () => {
    try {
        const response = await axios.get(route('public.categories.list'));

        categories.value = response.data.categories;
    } catch (err) {
        console.error('list-examples# Problem fetching categories:', err);
    }
};

const fetchExamples = async () => {
    try {
        state.value = LOADING;

        const response = await axios.get(route('public.examples.list'));

        examples.value = response.data.examples;

        state.value = LOADED;
    } catch (err) {
        console.error('list-examples# Problem fetching examples:', err);
        state.value = HAS_ERROR;
    }
};

const loadPage = () => {
    fetchCategories();
    fetchExamples();
};

onMounted(loadPage);

const filteredExamples = computed(() => {
    let filtered = examples.value;

    if (searchTerms.value) {
        const matchesFound = (example) => {
            return example.name.toLowerCase().includes(searchTerms.value.toLowerCase())
                || example.category.name.toLowerCase().includes(searchTerms.value.toLowerCase())
                || example.summary.toLowerCase().includes(searchTerms.value.toLowerCase())
                || example.conclusion.toLowerCase().includes(searchTerms.value.toLowerCase())
                || example.slug.toLowerCase().includes(searchTerms.value.toLowerCase())
                || example.tags.some(tag => tag.toLowerCase().includes(searchTerms.value.toLowerCase()));
        };

        filtered = filtered.filter(matchesFound);
    }

    if (activeCategory.value === 'all') return filtered;

    filtered = filtered.filter(example => example.category.slug === activeCategory.value);

    return filtered;
});

const hasExamples = computed(() => filteredExamples.value.length > 0);

const handleSelectCategory = async (categorySlug) => {
    activeCategory.value = categorySlug;

    await router.replace({
        query: {
            category: categorySlug,
        },
    });
};
</script>

<template>
    <div class="flex-1 w-full max-w-7xl mx-auto flex flex-col p-8">
        <div class="flex flex-col">
            <h1>Examples</h1>

            <p class="text-gray-600 mt-2">
                A collection of full projects, resources, experiments, and learning.
            </p>

            <div class="flex flex-col md:flex-row justify-between gap-4 mt-4">
                <div class="flex flex-wrap gap-2">
                    <button
                        type="button"
                        class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-200 border whitespace-nowrap"
                        :class="['px-5 py-2 rounded-full text-sm font-bold transition-all duration-200 border whitespace-nowrap', {
                            'bg-indigo-600 text-white border-indigo-600 shadow-md': activeCategory === 'all',
                            'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:border-gray-300': activeCategory !== 'all',
                        }]"
                        rounded
                        @click="() => handleSelectCategory('all')"
                    >
                        View all
                    </button>

                    <button
                        v-for="category in categories"
                        :key="`category-${category.slug}`"
                        type="button"
                        :class="['px-5 py-2 rounded-full text-sm font-bold transition-all duration-200 border whitespace-nowrap', {
                            'bg-indigo-600 text-white border-indigo-600 shadow-md': activeCategory === category.slug,
                            'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:border-gray-300': activeCategory !== category.slug,
                        }]"
                        @click="() => handleSelectCategory(category.slug)"
                    >{{ category.name }}</button>
                </div>

                <div>
                    <a-input-search v-model="searchTerms" />
                </div>
            </div>
        </div>

        <div v-if="isLoading" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 mt-4">
            <div v-for="n in 6" :key="n" class="rounded-xl overflow-hidden border">
                <Skeleton height="200px" width="100%"></Skeleton>
                <div class="p-4">
                    <Skeleton width="60%" height="1.5rem" class="mb-2"></Skeleton>
                    <Skeleton width="30%" height="1rem"></Skeleton>
                </div>
            </div>
        </div>

        <div v-else-if="isLoaded && hasExamples" class="mt-4">
            <TransitionGroup
                name="list"
                tag="div"
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8"
            >
                <router-link
                    v-for="example in filteredExamples"
                    :key="example.slug"
                    :to="{
                        name: 'public.examples.show',
                        params: {
                            category: example.category.slug,
                            example: example.slug,
                        },
                    }"
                    class="group flex flex-col bg-white rounded-2xl overflow-hidden border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-full"
                >
                    <div class="relative aspect-video w-full overflow-hidden bg-gray-100">
                        <a-image
                            v-if="example.images?.length > 0"
                            :src="`/storage/examples/${example.slug}/${example.images?.[0]?.filename}`"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
                            background="#f3f4f6"
                            alt="Example image"
                        />

                        <div v-else class="w-full h-full flex items-center justify-center bg-linear-to-br from-gray-800 to-gray-900 group-hover:from-indigo-900 group-hover:to-purple-900 transition-colors duration-500">
                            <div class="text-center opacity-50">
                                <i class="pi pi-image text-white" style="font-size: 48px;"></i>
                            </div>
                        </div>

                        <div class="absolute top-3 right-3">
                             <Tag
                                class="bg-white/90! text-gray-800! backdrop-blur-sm border shadow-sm font-semibold text-xs uppercase"
                                :value="example.category.name"
                                rounded
                            />
                        </div>
                    </div>

                    <div class="p-8 flex flex-col flex-1">
                        <h3 class="group-hover:text-indigo-600! transition-colors">{{ example.name }}</h3>

                        <p class="text-gray-600 text-sm line-clamp-2 mt-2">
                            See project details, resources, and live demos.
                        </p>

                        <div class="flex items-center text-indigo-600 font-semibold text-sm pt-4 mt-auto">
                            <span>View</span>
                            <i class="pi pi-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                        </div>
                    </div>
                </router-link>
            </TransitionGroup>
        </div>

        <a-card v-else-if="isLoaded && !hasExamples" class="flex flex-col items-center justify-center p-8 mt-4">
            <div class="w-16 h-16 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center mb-4">
                <i class="pi pi-search" style="font-size: 24px;"></i>
            </div>

            <h3>No examples found</h3>

            <p v-if="searchTerms" class="max-w-xl text-center text-gray-600 wrap-break-word mt-2">
                We couldn't find any examples matching <strong>{{ searchTerms }}</strong> in the <strong class="capitalize font-semibold">{{ activeCategory }}</strong> category.
            </p>
            <p v-else class="max-w-xl text-center text-gray-600 wrap-break-word mt-2">
                We couldn't find any examples in the <strong class="capitalize font-semibold">{{ activeCategory }}</strong> category.
            </p>

            <Button
                type="button"
                class="mt-4"
                severity="secondary"
                icon="pi pi-eye"
                label="View All Examples"
                @click="$router.push({ name: 'public.examples.list' })"
            />
        </a-card>

        <div v-else-if="hasError" class="w-full mt-12 flex flex-col items-center justify-center text-center">
            <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center">
                <i class="pi pi-exclamation-circle" style="font-size: 24px;"></i>
            </div>

            <h3 class="mt-4">Something went wrong</h3>

            <p class="mt-4">We failed to load the project examples.</p>

            <Button
                type="button"
                class="mt-4"
                severity="danger"
                icon="pi pi-refresh"
                label="Try again"
                @click="loadPage"
            />
        </div>

    </div>
</template>

<style scoped>
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
</style>
