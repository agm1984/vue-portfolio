<template>
    <a-card class="p-32">
        <img :src="imageUrl">
    </a-card>
</template>

<script>
import axios from 'axios';

const IS_LOADING = 0;
const IS_LOADED = 1;

export default {
    name: 'show-example-images',

    props: {},

    data() {
        return {
            state: IS_LOADING,
            image: {},
            imageUrl: '',
        };
    },

    computed: {},

    created() {
        console.log('filename', this.$route.params.filename);
        this.initialFilename = this.$route.params.filename;
    },

    mounted() {
        return this.fetchExample();
    },

    methods: {
        async fetchExample() {
            try {
                const images = await axios.get(route('public.examples.images', [this.$route.params.example, this.$route.params.filename]));

                // console.log('params', this.$route.params);
                // console.log('image', images.data);

                this.image = images.data.image;
                this.imageUrl = images.data.image_url;

                this.state = IS_LOADED;

                return undefined; // resolve promise, and do nothing
            } catch (err) {
                throw new Error(`show-example-image# Problem fetching image and image URL: ${err}`);
            }
        },
    },

};
</script>
