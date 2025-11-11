<script setup>
import { ref, computed, watch } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import Button from 'primevue/button';

useHead({
    title: 'Examples',
});

// Constants
const LOADING = 'is-loading';
const LOADED = 'is-loaded';
const HAS_ERROR = 'is-error';

// Keep the component name (useful for devtools)
defineOptions({ name: 'examples' });

// State
const state = ref(LOADING);
const categories = ref([]);
const examples = ref([]);

// Derived state
const isLoading = computed(() => state.value === LOADING);
const isLoaded = computed(() => state.value === LOADED);
const hasError = computed(() => state.value === HAS_ERROR);

// Router (avoid clashing with the global Ziggy `route()` helper)
const currentRoute = useRoute();

// Actions
async function fetchAllExamples() {
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

function handleScrollDown() {
    window.scrollTo({
        top: window.innerHeight / 2,
        behavior: 'smooth',
    });
}

function handleTryAgain() {
    fetchAllExamples();
}

watch(() => currentRoute.fullPath, fetchAllExamples, { immediate: true });
</script>

<template>
  <div class="flex flex-col w-full h-auto p-8">
        <h1>Examples</h1>

        <div class="flex items-center justify-end gap-4">
                <router-link
                        :to="{ name: 'public.examples.list' }"
                        class="font-bold rounded-sm"
                        active-class="text-white bg-grey-900 border-1 border-primary"
                        exact-active-class="text-white bg-grey-900 border-1 border-primary"
                        title="Show everything"
                >
                    View all
                </router-link>

                <router-link
                    v-for="category in categories"
                    :key="category.slug"
                    :to="{ name: 'public.examples.list', params: { category: category.slug } }"
                    class="font-bold rounded-sm"
                    active-class="text-white bg-grey-900 border-1 border-primary"
                    :title="`Show only ${category.name}`"
                >
                    {{ category.name }}
                </router-link>
        </div>

        <a-card class="w-full grid grid-cols-2 gap-4 p-8">
            <router-link
                v-for="example in examples"
                :key="example.slug"
                class="w-full inline-flex bg-gray-100"
                :to="{ name: 'public.examples.show', params: { category: example.category.slug, example: example.slug } }"
            >
                <a-tilt v-if="example.images?.length > 0" class="self-stretch">
                    <a-image
                        :src="`/storage/examples/${example.slug}/${example.images?.[0]?.filename}`"
                        class="w-full object-cover aspect-video"
                        background="#ffffff"
                        alt="Example image"
                    >
                        <div class="w-full bg-gray-900 text-white p-2">
                            <span>{{ example.name }}</span>
                        </div>

                        <div class="absolute bottom-0 right-0 bg-gray-100 text-gray-900 p-2">
                            <span>{{ example.category.name }}</span>
                        </div>
                    </a-image>
                </a-tilt>

                <a-area-empty v-else class="w-full flex items-center justify-center bg-gray-100 relative">
                    <i class="pi pi-image text-6xl! text-gray-900"></i>
                    <div class="absolute top-0 left-0 right-0 w-full bg-gray-900 text-white text-left p-2">
                        <span>{{ example.name }}</span>
                    </div>

                    <div class="absolute bottom-0 right-0 bg-gray-100 text-gray-900 p-2">
                        <span>{{ example.category.name }}</span>
                    </div>
                </a-area-empty>
            </router-link>

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
        </a-card>

        <div class="flex justify-center w-full mt-32 text-primary">
            △△△
        </div>
  </div>
</template>
