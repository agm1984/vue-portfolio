<script setup>
import { ref, computed, watch } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import Tag from 'primevue/tag';
import ProgressSpinner from 'primevue/progressspinner';
// import CommentsManager from './comments-manager.vue';

useHead({
    title: 'Example',
});

const IS_LOADING = 0;
const IS_LOADED = 1;

const state = ref(IS_LOADING);
const example = ref({
    status: null,
    category: {},
    name: '',
    slug: '',
    summary: '',
    conclusion: '',
    images: [],
    links: [],
    tags: [],
});

const isLoading = computed(() => state.value === IS_LOADING);
const isLoaded = computed(() => state.value === IS_LOADED);

const currentRoute = useRoute();

const fetchExample = async () => {
  try {
    state.value = IS_LOADING;
    const res = await axios.get(route('public.examples.show', currentRoute.params.example));
    example.value = res.data.example;
    state.value = IS_LOADED;
  } catch (err) {
    console.error(`show-example# Problem fetching example:`, err);
  }
}

watch(() => currentRoute.params.example, fetchExample, { immediate: true });
</script>

<template>
  <div v-if="isLoaded" class="container flex flex-col w-full">
    <h1>{{ example.name }}</h1>

    <a-card class="p-8 main">
      <h2 level="2" class="mb-16">Summary</h2>
      <p>
        {{ example.summary }}
      </p>

      <h2 level="2" class="mt-32 mb-16">Images</h2>
      <div class="w-full grid grid-cols-2 gap-4">
        <router-link
          v-for="image in example.images"
          :key="image.image_id"
          :to="{ name: 'public.examples.images', params: { filename: image.filename } }"
          class="relative block bg-no-repeat bg-cover cursor-pointer w-full aspect-video"
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

    <a-card class="p-8 links">
      <h2 level="2">Links</h2>

      <a
        v-for="link in example.links"
        :key="`link-${link.url}`"
        class="mt-16"
        :href="link.url"
        target="_blank"
      >
        {{ link.name }}
      </a>
    </a-card>

    <a-card class="p-8 tags">
      <h2 level="2" class="mb-16">Tags</h2>

      <div class="flex flex-wrap gap-4">
        <Tag
            v-for="(tag, index) in example.tags"
            :key="`example-tag-${index}`"
            :value="tag"
            rounded
        />
      </div>
    </a-card>
  </div>

  <ProgressSpinner v-else />
</template>
