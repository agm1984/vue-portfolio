<script setup>
import { ref, computed, watch } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
// import CommentsManager from './comments-manager.vue';

useHead({
    title: 'Example',
});

defineOptions({ name: 'show-example' });

const IS_LOADING = 0;
const IS_LOADED = 1;

const state = ref(IS_LOADING);
const example = ref({
  name: '',
  slug: '',
  summary: '',
  conclusion: '',
  images: [],
  links: [],
  tags: [],
  category: {},
});

const isLoading = computed(() => state.value === IS_LOADING);
const isLoaded = computed(() => state.value === IS_LOADED);

const currentRoute = useRoute();

async function fetchExample () {
  try {
    state.value = IS_LOADING;
    const res = await axios.get(route('public.examples.show', currentRoute.params.example));
    example.value = res.data.example;
    state.value = IS_LOADED;
    document.title = example.value?.name || 'Example';
  } catch (err) {
    console.error(`show-example# Problem fetching example:`, err);
  }
}

// Fetch initially and whenever the route param changes (e.g., in-view navigation)
watch(
  () => currentRoute.params.example,
  () => { fetchExample() },
  { immediate: true },
);
</script>

<template>
  <div v-if="isLoaded" class="container flex flex-col w-full">
    <h1 class="main__heading">{{ example.name }}</h1>

    <a-card class="p-32 main">
      <h2 level="2" class="mb-16">Summary</h2>
      <p>
        {{ example.summary }}
      </p>

      <h2 level="2" class="mt-32 mb-16">Images</h2>
      <div class="images__container">
        <router-link
          v-for="image in example.images"
          :key="image.image_id"
          :to="{ name: 'public.examples.images', params: { filename: image.filename } }"
          class="relative block bg-no-repeat bg-cover cursor-pointer border w-32 h-32"
          title="Click to enlarge"
          :style="{ backgroundImage: `url('/storage/examples/${example.slug}/${image.filename}')` }"
        ></router-link>
      </div>

      <h2 level="2" class="mt-32 mb-16">Conclusion</h2>
      <p>
        {{ example.conclusion }}
      </p>

      <h2 level="2" class="mt-32 mb-16">Feedback</h2>
      <!-- <comments-manager></comments-manager> -->
    </a-card>

    <a-card class="p-32 links">
      <h2 level="2">Links</h2>

      <a
        v-for="link in example.links"
        :key="`link-${link.url}`"
        class="mt-16"
        :href="link.url"
      >
        {{ link.name }}
      </a>
    </a-card>

    <a-card class="p-32 tags">
      <h2 level="2" class="mb-16">Tags</h2>

      <div class="flex flex-wrap gap-4">
        <div
          v-for="tag in example.tags"
          :key="`tag-${tag.name}`"
          class="bg-blue-700 text-white"
        >
          {{ tag.name }}
        </div>
      </div>
    </a-card>
  </div>
</template>

<style>
  .container {
    display: grid;
    grid-gap: 1.6rem;
    grid-template-columns: 3fr 1fr;
    grid-auto-rows: fit-content(1em);
    grid-template-areas:
      "heading heading"
      "main links"
      "main tags"
      "main .";
  }

  @media screen and (max-width: 720px) {
    .container {
      grid-template-areas:
        "heading heading"
        "links links"
        "main main"
        "tags tags";
    }
  }

  .main__heading {
    grid-column: 1 / -1;
  }

  .main {
    background-color: white;
    grid-area: main;
  }

  .images__container {
    display: grid;
    grid-gap: 1.6rem;
    grid-template-columns: repeat(auto-fit, minmax(256px, 1fr));
  }

  .links {
    display: flex;
    flex-direction: column;
    background-color: white;
    grid-area: links;
  }

  .tags {
    background-color: white;
    grid-area: tags;
  }
</style>
