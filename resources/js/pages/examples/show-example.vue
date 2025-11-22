<script setup>
import { ref, computed, watch } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import Tag from 'primevue/tag';
import Button from 'primevue/button';
import Skeleton from 'primevue/skeleton';

useHead({
    title: 'Example Details',
});

const IS_LOADING = 0;
const IS_LOADED = 1;

const state = ref(IS_LOADING);
const example = ref({
    status: null,
    category: { name: '', slug: '' },
    name: '',
    slug: '',
    summary: '',
    conclusion: '',
    images: [],
    links: [],
    tags: [],
    created_at_human: '', // todo: add dates
});

const isLoaded = computed(() => state.value === IS_LOADED);
const isLoading = computed(() => state.value === IS_LOADING);

const currentRoute = useRoute();
const router = useRouter();

const fetchExample = async () => {
    try {
        state.value = IS_LOADING;

        const res = await axios.get(route('public.examples.show', currentRoute.params.example));

        example.value = res.data.example;

        state.value = IS_LOADED;
        // useHead({ title: example.value.name });
    } catch (err) {
        console.error(`show-example# Problem fetching example:`, err);
    }
}

watch(() => currentRoute.params.example, fetchExample, { immediate: true });

const goBack = () => {
    router.push({ name: 'public.examples.list' });
};
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

        <div v-else class="flex flex-col">
            <header>
                <Button
                    type="button"
                    class="text-gray-600! hover:text-indigo-600"
                    icon="pi pi-arrow-left"
                    label="Back to Projects"
                    text
                    @click="goBack"
                />

                <div class="flex flex-col gap-4 mt-4">
                    <h1>{{ example.name }}</h1>

                    <div class="flex items-center gap-3">
                        <Tag
                            :value="example.category.name"
                            severity="info"
                            class="uppercase tracking-widest text-xs! font-bold bg-indigo-50! text-indigo-600! border border-indigo-100"
                        />
                    </div>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-8">
                <main class="lg:col-span-8 flex flex-col gap-8">
                    <section class="prose max-w-none text-lg text-gray-600">
                        <p>{{ example.summary }}</p>
                    </section>

                    <section v-if="example.images.length > 0">
                        <h3 class="flex items-center gap-2">
                            <i class="pi pi-images text-indigo-500"></i> Gallery
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                            <router-link
                                v-for="(image, index) in example.images"
                                :key="image.image_id"
                                :to="{ name: 'public.examples.image', params: { filename: image.filename } }"
                                class="group relative block rounded-xl overflow-hidden shadow-sm border aspect-video"
                                title="View Full Size"
                            >
                                <a-image
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                    :src="`/storage/examples/${example.slug}/${image.filename}`"
                                    background="#ffffff"
                                    :alt="`Screenshot ${index + 1}`"
                                />

                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                    <i
                                        class="pi pi-search-plus text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 drop-shadow-lg"
                                        style="font-size: 24px;"
                                    ></i>
                                </div>
                            </router-link>
                        </div>
                    </section>

                    <section v-if="example.conclusion" class="bg-indigo-50 rounded-2xl border-l-4 border-indigo-500 p-8">
                        <h3>Final Thoughts</h3>
                        <p class="text-gray-600 mt-2">{{ example.conclusion }}</p>
                    </section>

                    <section class="border-t pt-8">
                        <h3>Discussion</h3>
                        <comments-manager class="mt-4"></comments-manager>
                    </section>
                </main>

                <aside class="lg:col-span-4 space-y-8">
                    <div class="sticky top-[99px] space-y-8">
                        <a-card class="p-8">
                            <h3>Details</h3>

                            <div class="space-y-8 mt-2">
                                <div v-if="example.links.length > 0">
                                    <h6>Links & Resources</h6>

                                    <div class="flex flex-col gap-2 mt-2">
                                        <a
                                            v-for="link in example.links"
                                            :key="`link-${link.url}`"
                                            :href="link.url"
                                            target="_blank"
                                            class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-gray-600 transition-colors group"
                                        >
                                            <span class="font-semibold text-sm">{{ link.name }}</span>
                                            <i class="pi pi-external-link text-xs text-gray-500 group-hover:text-indigo-500"></i>
                                        </a>
                                    </div>
                                </div>

                                <div v-if="example.tags.length > 0">
                                    <h6>Technologies</h6>

                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <Tag
                                            v-for="(tag, index) in example.tags"
                                            :key="`example-tag-${index}`"
                                            class="bg-white! text-gray-700! border font-normal!"
                                            :value="tag"
                                            rounded
                                        />
                                    </div>
                                </div>

                                <div class="border-t pt-4">
                                    <p class="text-sm text-gray-600 text-center">
                                        Have questions about this code?
                                        <a href="#comments" class="text-indigo-600 font-bold hover:underline ml-2">Ask below.</a>
                                    </p>
                                </div>
                            </div>
                        </a-card>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</template>
