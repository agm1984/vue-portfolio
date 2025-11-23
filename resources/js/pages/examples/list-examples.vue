<script setup>
import { computed, onMounted, watch } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute, useRouter } from 'vue-router';
import Button from 'primevue/button';
import Tag from 'primevue/tag';
import Skeleton from 'primevue/skeleton';
import { usePublicExamplesStore } from '~/store/publicExamples';

useHead({
    title: 'Examples',
});

const currentRoute = useRoute();
const router = useRouter();
const publicExamples = usePublicExamplesStore();

const setUrlParams = async () => {
    await router.replace({
        query: publicExamples.formattedFilters,
    });
};

const loadPage = () => {
    publicExamples.getUrlParams(currentRoute.query);

    if (!publicExamples.allCategories.length) {
        publicExamples.getAllCategories();
    }

    if (!publicExamples.allExamples.length) {
        publicExamples.getAllExamples();
    }

    setUrlParams();
};

onMounted(loadPage);

const resetPage = async () => {
    await router.replace({ query: {} });
    publicExamples.$reset();
    loadPage();
};

const hasExamples = computed(() => publicExamples.filteredExamples.length > 0);

const handleSelectCategory = async (categorySlug) => {
    publicExamples.activeCategory = categorySlug;
};

watch(() => publicExamples.searchTerms, setUrlParams);
watch(() => publicExamples.activeCategory, setUrlParams);
</script>

<template>
    <div class="flex-1 w-full max-w-7xl mx-auto flex flex-col p-8">
        <div class="flex flex-col">
            <h1>Examples</h1>

            <p class="text-gray-600 mt-2">
                A collection of full projects, resources, experiments, and learning.
            </p>

            <div v-if="publicExamples.isFetchingCategories" class="flex flex-col md:flex-row justify-between gap-4 mt-4">
                <div class="flex flex-wrap gap-2">
                    <Skeleton width="6rem" height="2.4rem" borderRadius="2rem"></Skeleton>

                    <Skeleton width="7rem" height="2.4rem" borderRadius="2rem"></Skeleton>
                    <Skeleton width="5rem" height="2.4rem" borderRadius="2rem"></Skeleton>
                    <Skeleton width="8rem" height="2.4rem" borderRadius="2rem"></Skeleton>
                </div>

                <div class="w-full md:w-auto">
                    <Skeleton class="w-full md:w-64" height="2.4rem" borderRadius="0.375rem"></Skeleton>
                </div>
            </div>

            <div v-else class="flex flex-col md:flex-row justify-between gap-4 mt-4">
                <div class="flex flex-wrap gap-2">
                    <button
                        type="button"
                        class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-200 border whitespace-nowrap"
                        :class="['px-5 py-2 rounded-full text-sm font-bold transition-all duration-200 border whitespace-nowrap', {
                            'bg-indigo-600 text-white border-indigo-600 shadow-md': publicExamples.activeCategory === 'all',
                            'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:border-gray-300': publicExamples.activeCategory !== 'all',
                        }]"
                        rounded
                        @click="() => handleSelectCategory('all')"
                    >
                        View all
                    </button>

                    <button
                        v-for="category in publicExamples.allCategories"
                        :key="`category-${category.slug}`"
                        type="button"
                        :class="['px-5 py-2 rounded-full text-sm font-bold transition-all duration-200 border whitespace-nowrap', {
                            'bg-indigo-600 text-white border-indigo-600 shadow-md': publicExamples.activeCategory === category.slug,
                            'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:border-gray-300': publicExamples.activeCategory !== category.slug,
                        }]"
                        @click="() => handleSelectCategory(category.slug)"
                    >{{ category.name }}</button>
                </div>

                <div>
                    <a-input-search v-model="publicExamples.searchTerms" />
                </div>
            </div>
        </div>

        <div v-if="publicExamples.isFetchingExamples" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 mt-4">
            <div v-for="n in 6" :key="n" class="rounded-xl overflow-hidden border">
                <Skeleton height="200px" width="100%"></Skeleton>
                <div class="p-4">
                    <Skeleton width="60%" height="1.5rem" class="mb-2"></Skeleton>
                    <Skeleton width="30%" height="1rem"></Skeleton>
                </div>
            </div>
        </div>

        <div v-else-if="!publicExamples.isFetchingExamples && hasExamples" class="mt-4">
            <TransitionGroup
                name="list"
                tag="div"
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8"
            >
                <router-link
                    v-for="example in publicExamples.filteredExamples"
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
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
                            :src="`/storage/examples/${example.slug}/${example.images?.[0]?.filename}`"
                            background="#ffffff"
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
                            <i class="pi pi-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                        </div>
                    </div>
                </router-link>
            </TransitionGroup>
        </div>

        <a-card v-else-if="!publicExamples.isFetchingExamples && !hasExamples" class="flex flex-col items-center justify-center p-8 mt-4">
            <div class="w-16 h-16 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center mb-4">
                <i class="pi pi-search" style="font-size: 24px;"></i>
            </div>

            <h3>No examples found</h3>

            <p v-if="publicExamples.searchTerms" class="max-w-xl text-center text-gray-600 wrap-break-word mt-2">
                We couldn't find any examples matching <strong>{{ publicExamples.searchTerms }}</strong> in the <strong class="capitalize font-semibold">{{ publicExamples.activeCategory }}</strong> category.
            </p>
            <p v-else class="max-w-xl text-center text-gray-600 wrap-break-word mt-2">
                We couldn't find any examples in the <strong class="capitalize font-semibold">{{ publicExamples.activeCategory }}</strong> category.
            </p>

            <Button
                type="button"
                class="mt-4"
                severity="secondary"
                icon="pi pi-refresh"
                label="Reset page"
                @click="resetPage"
            />
        </a-card>

        <div v-else class="w-full mt-12 flex flex-col items-center justify-center text-center">
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
                @click="resetPage"
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
