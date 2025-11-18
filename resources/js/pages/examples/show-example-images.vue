<script setup>
import { ref, onMounted } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

useHead({
    title: 'Example Image',
});

const IS_LOADING = 0;
const IS_LOADED = 1;
const state = ref(IS_LOADING);
const image = ref({});
const imageUrl = ref('');

const currentRoute = useRoute();

const fetchExample = async () => {
    try {
        const { example, filename } = currentRoute.params;

        const response = await axios.get(route('public.examples.images', [example, filename]));

        image.value = response.data.image;
        imageUrl.value = response.data.image_url;
        state.value = IS_LOADED;
    } catch (err) {
        throw new Error(`show-example-image# Problem fetching image and image URL: ${err}`);
    }
};

onMounted(fetchExample);
</script>

<template>
    <div class="flex-1 w-full max-w-5xl mx-auto flex flex-col p-8">
        <a-card class="p-8">
            <img :src="imageUrl" class="w-full aspect-video" alt="Example image" />
        </a-card>
    </div>
</template>
