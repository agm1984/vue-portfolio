<script setup>
import { computed } from 'vue';
import { usePublicExamplesStore } from '~/store/publicExamples';

const publicExamples = usePublicExamplesStore();

const isFeatured = (example) => !!example.is_featured;
const featuredExamples = computed(() => publicExamples.allExamples.filter(isFeatured));
</script>

<template>
    <div v-if="featuredExamples.length > 0" class="mt-24 mb-12">
        <div class="flex flex-col md:flex-row justify-between items-end mb-4 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Featured Examples</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Highlights from my recent engineering challenges.</p>
            </div>
            <router-link :to="{ name: 'public.examples.list' }" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 font-semibold flex items-center gap-2 group">
                View All
                <i class="pi pi-arrow-right transition-transform group-hover:translate-x-1"></i>
            </router-link>
        </div>

        {{ featuredExamples[0] }}

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <router-link
                v-for="example in featuredExamples"
                :key="example.id"
                :to="{ name: 'public.examples.show', params: { category: example.category.slug, example: example.slug } }"
                class="group relative flex flex-col h-full"
            >
                <div class="h-full bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/10 hover:border-indigo-500/30 hover:-translate-y-1">
                    <div class="h-48 overflow-hidden bg-gray-100 dark:bg-gray-900 relative">
                        <img
                            v-if="example.images?.[0]"
                            :src="`/storage/examples/${example.slug}/${example.images[0].filename}`"
                            :alt="example.title"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        />
                        <div v-else class="w-full h-full bg-linear-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                            <i class="pi pi-image text-4xl text-gray-400"></i>
                        </div>

                        <div class="absolute top-4 right-4 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-100/70 text-amber-700 dark:bg-amber-900/70 dark:text-amber-200 shadow-sm mb-6">
                            <i class="pi pi-star-fill"></i>
                            Featured
                        </div>
                    </div>

                    <div class="p-6 flex flex-col grow">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ example.title }}
                        </h3>

                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-6 grow">
                            {{ example.summary }}
                        </p>

                        <div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-gray-100 dark:border-gray-700/50">
                            <span
                                v-for="tag in example.tags.slice(0, 3)"
                                :key="tag"
                                class="text-xs font-medium px-2.5 py-1 rounded-md bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300"
                            >
                                {{ tag }}
                            </span>
                            <span v-if="example.tags.length > 3" class="text-xs font-medium px-2 py-1 text-gray-500">
                                +{{ example.tags.length - 3 }}
                            </span>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
</template>
