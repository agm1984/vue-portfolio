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
  state.value = LOADING;
  try {
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

// Fetch on initial load and whenever the route changes
watch(
  () => currentRoute.fullPath,
  () => {
    fetchAllExamples()
  },
  { immediate: true },
);
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

    <a-card class="w-full grid grid-cols-2 gap-4">
      <router-link
        v-for="example in examples"
        :key="example.slug"
        :to="{ name: 'public.examples.show', params: { category: example.category.slug, example: example.slug } }"
      >
        <a-tilt>
          <a-card class="">
            <a-image
              :src="`/storage/examples/${example.slug}/${example.images[0].filename}`"
              width="448"
              height="256"
              background="#ffffff"
              alt="example image"
            >
              <div class="px-16 py-8 bg-transparent-grey">
                <span class="text-white font-nunito">
                  {{ example.name }}
                </span>
              </div>

              <div class="absolute bottom-0 right-0">{{ example.category.name }}</div>
            </a-image>
          </a-card>
        </a-tilt>
      </router-link>

      <div v-if="hasError" class="w-full">
        <div class="bg-red-700 text-white">
          There was a problem loading this page.
          <Button
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
