<template>
    <div v-if="isLoaded" class="container flex flex-col w-full h-auto xl:w-1024 ">
        <a-heading level="1" class="main__heading" dark>
            {{ example.name }}
        </a-heading>

        <a-card class="p-32 main" with-geometry>
            <a-heading level="2" class="mb-16">Summary</a-heading>

            <a-paragraph>
                {{ example.summary }}
            </a-paragraph>


            <a-heading level="2" class="mt-32 mb-16">Images</a-heading>

            <div class="images__container">
                <router-link
                    v-for="image in example.images"
                    :key="image.image_id"
                    :to="{ name: 'public.examples.images', params: { filename: image.filename } }"
                    class="relative block bg-no-repeat bg-cover cursor-pointer border-1 border-primary w-256 h-128"
                    title="Click to enlarge"
                    :style="{ backgroundImage: `url('/storage/examples/${example.slug}/${image.filename}')` }"
                ></router-link>
            </div>

            <a-heading level="2" class="mt-32 mb-16">Conclusion</a-heading>

            <a-paragraph>
                {{ example.conclusion }}
            </a-paragraph>
        </a-card>

        <a-card class="p-32 links" with-geometry>
            <a-heading level="2">Links</a-heading>

            <a-button
                v-for="link in example.links"
                :key="`link-${link.url}`"
                class="mt-16"
                tag="a"
                :href="link.url"
                type="is-link"
                outlined
            >
                {{ link.name }}
            </a-button>
        </a-card>

        <a-card class="p-32 tags" with-geometry>
            <a-heading level="2" class="mb-16">Tags</a-heading>

            <b-taglist>
                <b-tag
                    v-for="tag in example.tags"
                    :key="`tag-${tag.name}`"
                    type="is-info"
                    rounded
                >
                    {{ tag.name }}
                </b-tag>
            </b-taglist>
        </a-card>

    </div>
</template>

<script>
import axios from 'axios';

const IS_LOADING = 0;
const IS_LOADED = 1;

export default {
    name: 'show-example',

    props: {},

    data() {
        return {
            state: IS_LOADING,
            image: {},
            example: {
                category: {},
            },
        };
    },

    metaInfo() {
        return {
            title: this.example.name,
        };
    },

    computed: {
        isLoading() {
            return (this.state === IS_LOADING);
        },

        isLoaded() {
            return (this.state === IS_LOADED);
        },

    },

    mounted() {
        return this.fetchExample();
    },

    methods: {
        async fetchExample() {
            try {
                const example = await axios.get(route('public.examples.show', this.$route.params.example));

                // console.log('params', this.$route.params);
                console.log('example', example.data);

                this.example = example.data.example;

                this.state = IS_LOADED;

                return undefined; // resolve promise, and do nothing
            } catch (err) {
                throw new Error(`show-example# Problem fetching example: ${err}`);
            }
        },
    },

};
</script>

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
