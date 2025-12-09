<script setup>
import { ref, computed, watch } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute, useRouter } from 'vue-router';
import Tag from 'primevue/tag';
import Button from 'primevue/button';
import Skeleton from 'primevue/skeleton';
import { api } from '~/services/api';

useHead({
    title: 'Example Details',
});

const IS_LOADING = 'is-loading';
const IS_LOADED = 'is-loaded';
const IS_ERROR = 'is-error';
const state = ref(IS_LOADING);

const isLoading = computed(() => state.value === IS_LOADING);
const isLoaded = computed(() => state.value === IS_LOADED);

const example = ref({
    created_at_nice: '',
    updated_at_nice: '',
    created_at_diff: '',
    updated_at_diff: '',
    status: null,
    category: { name: '', slug: '' },
    name: '',
    slug: '',
    summary: '',
    conclusion: '',
    images: [],
    links: [],
    tags: [],
});

const currentRoute = useRoute();
const router = useRouter();

const fetchExample = async () => {
    try {
        state.value = IS_LOADING;

        const res = await api.get(route('public.examples.show', currentRoute.params.example));

        example.value = res.data.example;

        state.value = IS_LOADED;
    } catch (err) {
        state.value = IS_ERROR;
        console.error(`show-example# Problem fetching example:`, err);
    }
}

watch(() => currentRoute.params.example, fetchExample, { immediate: true });

const goBack = () => router.push({ name: 'public.examples.list' });
</script>

<template>
    <div class="w-full max-w-7xl mx-auto p-6 md:p-12 min-h-screen flex flex-col">
        <div v-if="isLoading" class="animate-pulse space-y-8">
            <Skeleton width="100px" height="2rem" class="mb-4" />
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8 space-y-4">
                    <Skeleton width="70%" height="4rem" />
                    <Skeleton width="100%" height="20rem" />
                    <Skeleton width="100%" height="10rem" />
                </div>
                <div class="lg:col-span-4 space-y-4 mt-32">
                    <Skeleton width="100%" height="15rem" />
                </div>
            </div>
        </div>

        <div v-else-if="isLoaded" class="flex flex-col">
            <a-page-title
                :title="example.name"
                has-back
                @on-back="goBack"
            >
                <template #description>
                    <div class="flex items-center gap-4">
                        <Tag
                            class="uppercase tracking-widest text-xs! font-semibold bg-indigo-50! dark:bg-indigo-900/30! text-indigo-600! dark:text-indigo-300! border border-indigo-100 dark:border-indigo-800"
                            severity="info"
                            :value="example.category.name"
                        />
                    </div>
                </template>
            </a-page-title>

            <div class="flex flex-col gap-2 text-gray-600 dark:text-gray-400">
                <span class="text-sm">Added: {{ example.created_at_nice }} ({{ example.created_at_diff }})</span>
                <span
                    v-if="example.created_at_nice !== example.updated_at_nice"
                    class="text-sm">Last updated: {{ example.updated_at_nice }} ({{ example.updated_at_diff }})
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-4">
                <main class="lg:col-span-8 flex flex-col gap-8">
                    <section class="prose max-w-none text-lg text-gray-600 dark:text-gray-300">
                        <p>{{ example.summary }}</p>
                    </section>

                    <section v-if="example.images.length > 0">
                        <h3 class="flex items-center gap-2">
                            <i class="pi pi-images text-indigo-500 dark:text-indigo-400"></i> Gallery
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                            <router-link
                                v-for="(image, index) in example.images"
                                :key="image.image_id"
                                :to="{ name: 'public.examples.image', params: { filename: image.filename } }"
                                class="group relative block rounded-xl overflow-hidden shadow-sm border dark:border-gray-700 aspect-video"
                                title="View Full Size"
                            >
                                <a-image
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                    :src="`/storage/examples/${example.slug}/${image.filename}`"
                                    background="#ffffff"
                                    :alt="`Screenshot ${index + 1}`"
                                />

                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 flex items-center justify-center">
                                    <i
                                        class="pi pi-search-plus text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 drop-shadow-lg"
                                        style="font-size: 24px;"
                                    ></i>
                                </div>
                            </router-link>
                        </div>
                    </section>

                    <section v-if="example.conclusion" class="bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border-l-4 border-indigo-500 dark:border-indigo-400 p-8">
                        <h3 class="text-indigo-900 dark:text-indigo-100">Final Thoughts</h3>
                        <p class="text-gray-700 dark:text-gray-300 mt-2">{{ example.conclusion }}</p>
                    </section>

                    <section class="border-t border-gray-200 dark:border-gray-700 pt-8">
                        <h3 class="text-gray-900 dark:text-white">Discussion</h3>
                        <comments-manager class="mt-4"></comments-manager>
                    </section>
                </main>

                <aside class="lg:col-span-4 space-y-8">
                    <div class="sticky top-[99px] space-y-8">
                        <a-card class="p-8">
                            <h3>Details</h3>

                            <div class="space-y-8 mt-2">
                                <div>
                                    <h6>Links & Resources</h6>

                                    <div v-if="example.links.length > 0" class="flex flex-col gap-2 mt-2">
                                        <a
                                            v-for="link in example.links"
                                            :key="`link-${link.url}`"
                                            :href="link.url"
                                            target="_blank"
                                            class="flex items-center justify-between p-3 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 text-gray-700 dark:text-gray-200 group"
                                        >
                                            <span class="font-semibold text-sm">{{ link.name }}</span>
                                            <i class="pi pi-external-link text-xs text-gray-500 dark:text-gray-400 group-hover:text-indigo-500 dark:group-hover:text-indigo-400"></i>
                                        </a>
                                    </div>

                                    <a-area-empty v-else class="py-4 mt-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">No links yet</span>
                                    </a-area-empty>
                                </div>

                                <div>
                                    <h6>Technologies</h6>

                                    <div v-if="example.tags.length > 0" class="flex flex-wrap gap-2 mt-2">
                                        <Tag
                                            v-for="(tag, index) in example.tags"
                                            :key="`example-tag-${index}`"
                                            class="bg-white! dark:bg-gray-700! text-gray-700! dark:text-gray-200! border dark:border-gray-600 font-normal!"
                                            :value="tag"
                                            rounded
                                        />
                                    </div>

                                    <a-area-empty v-else class="py-4 mt-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">No tags yet</span>
                                    </a-area-empty>
                                </div>

                                <div class="border-t border-gray-300 dark:border-gray-700 pt-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                                        Have questions about this?
                                        <a href="#comments" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline ml-2">Ask below.</a>
                                    </p>
                                </div>
                            </div>
                        </a-card>
                    </div>
                </aside>
            </div>
        </div>

        <div v-else class="flex-1 flex items-center justify-center">
            <div class="text-center p-8 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 rounded-lg">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <i class="pi pi-exclamation-triangle" style="font-size: 24px;"></i>
                </div>

                <h3 class="text-red-700 dark:text-red-400">Error loading example</h3>

                <p class="text-red-600 dark:text-red-300 mt-2">
                    There was a problem loading this example. Please try again later.
                </p>

                <Button
                    type="button"
                    class="mt-4 p-button-danger p-button-text"
                    label="Back to Projects"
                    icon="pi pi-arrow-left"
                    @click="goBack"
                />
            </div>
        </div>
    </div>
</template>
