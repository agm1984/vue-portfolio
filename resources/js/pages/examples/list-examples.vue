<script setup>
import { ref, computed, watch } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import Button from 'primevue/button';
import Tag from 'primevue/tag';

useHead({
    title: 'Examples',
});

const currentRoute = useRoute();

const LOADING = 'is-loading';
const LOADED = 'is-loaded';
const HAS_ERROR = 'is-error';
const state = ref(LOADING);
const categories = ref([]);
const examples = ref([]);

const isLoading = computed(() => state.value === LOADING);
const isLoaded = computed(() => state.value === LOADED);
const hasError = computed(() => state.value === HAS_ERROR);

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

const handleScrollDown = () => {
    window.scrollTo({
        top: window.innerHeight / 2,
        behavior: 'smooth',
    });
}

const handleTryAgain = () => {
    fetchAllExamples();
}

watch(() => currentRoute.fullPath, fetchAllExamples, { immediate: true });
</script>

<template>
    <div class="max-w-5xl mx-auto flex flex-col w-full h-auto p-8">
        <div class="w-full h-10 flex items-center justify-between gap-4">
            <h1>Examples</h1>

            <div class="h-full flex items-center justify-end gap-4">
                <router-link
                    :to="{ name: 'public.examples.list' }"
                    :class="['h-full inline-flex items-center font-semibold', {
                        'border-b-2 mt-0.5': !currentRoute.params.category,
                    }]"
                    active-class=""
                    title="Show everything"
                >
                    View all
                </router-link>

                <router-link
                    v-for="category in categories"
                    :key="category.slug"
                    :to="{ name: 'public.examples.list', params: { category: category.slug } }"
                    class="h-full inline-flex items-center font-semibold"
                    active-class="border-b-2 mt-0.5"
                    :title="`Show only ${category.name}`"
                >
                    {{ category.name }}
                </router-link>
            </div>
        </div>

        <div v-if="examples.length" class="w-full grid md:grid-cols-2 xl:grid-cols-3 gap-4 mt-4">
            <router-link
                v-for="example in examples"
                :key="example.slug"
                class="w-full inline-flex bg-gray-200"
                :to="{ name: 'public.examples.show', params: { category: example.category.slug, example: example.slug } }"
            >
                <a-tilt v-if="example.images?.length > 0">
                    <a-image
                        :src="`/storage/examples/${example.slug}/${example.images?.[0]?.filename}`"
                        class="w-full object-cover aspect-video"
                        background="#ffffff"
                        alt="Example image"
                    >
                        <div class="w-full bg-white text-gray-900 p-2">
                            <span class="font-semibold">{{ example.name }}</span>
                        </div>

                        <div class="absolute bottom-0 right-0 p-2">
                            <Tag :value="example.category.name" severity="info" />
                        </div>
                    </a-image>
                </a-tilt>

                <div v-else class="w-full flex items-center justify-center relative">
                    <i class="pi pi-image text-6xl! text-gray-900"></i>
                    <div class="absolute top-0 left-0 right-0 w-full bg-white text-gray-900 text-left p-2">
                        <span class="font-semibold">{{ example.name }}</span>
                    </div>

                    <div class="absolute bottom-0 right-0 p-2">
                        <Tag :value="example.category.name" severity="info" />
                    </div>
                </div>
            </router-link>
        </div>

        <a-card v-else class="p-8">
            <a-area-empty>No matching examples</a-area-empty>
        </a-card>

        <div v-if="hasError" class="w-full">
            <div class="bg-red-700 text-white">
                There was a problem loading this page.
                <Button
                    type="button"
                    class="pt-8"
                    label="Try again"
                    @click="handleTryAgain"
                />
            </div>
        </div>
    </div>
</template>