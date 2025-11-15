<template>
    <div class="flex-1 w-full max-w-5xl mx-auto flex flex-col p-8">
        <a-card class="p-8">
            <img :src="imageUrl" class="w-full aspect-video" alt="Example image">
        </a-card>
    </div>
</template>

<script>
import axios from 'axios';

const IS_LOADING = 0;
const IS_LOADED = 1;

export default {
    data() {
        return {
            state: IS_LOADING,
            image: {},
            imageUrl: '',
        };
    },

    created() {
        this.initialFilename = this.$route.params.filename;
    },

    mounted() {
        return this.fetchExample();
    },

    methods: {
        async fetchExample() {
            try {
                const images = await axios.get(route('public.examples.images', [this.$route.params.example, this.$route.params.filename]));

                this.image = images.data.image;
                this.imageUrl = images.data.image_url;

                this.state = IS_LOADED;
            } catch (err) {
                throw new Error(`show-example-image# Problem fetching image and image URL: ${err}`);
            }
        },
    },

};
</script>
