<template>
    <div class="flex flex-col w-full h-auto p-32 xl:w-1024 xl:p-0">
        <h2 level="1" class="mb-16">
            Examples
        </h2>

        <div class="flex items-center justify-end">
            <router-link
                :to="{ name: 'public.examples.list' }"
                class="px-16 py-8 font-bold rounded-sm"
                active-class="text-white bg-primary border-1 border-primary"
                title="Show everything"
                exact
            >
                View all
            </router-link>

            <router-link
                v-for="category in categories"
                :key="category.slug"
                :to="{ name: 'public.examples.list', params: { category: category.slug } }"
                class="px-16 py-8 font-bold rounded-sm"
                active-class="text-white bg-primary border-1 border-primary"
                :title="`Show only ${category.name}`"
            >
                {{ category.name }}
            </router-link>
        </div>

        <a-card class="flex flex-wrap w-full p-16 mt-16 md:p-32" with-geometry>
            <router-link
                v-for="example in examples"
                :key="example.slug"
                :to="{ name: 'public.examples.show', params: { category: example.category.slug, example: example.slug } }"
                class="m-16"
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

                            <b-tag
                                class="absolute bottom-0 right-0"
                                type="is-light"

                            >{{ example.category.name }}</b-tag>
                        </a-image>
                    </a-card>
                </a-tilt>
            </router-link>

            <div v-if="hasError" class="w-full">
                <b-message type="is-danger">
                    There was a problem loading this page.
                    <a-button
                        class="pt-16"
                        type="is-danger"
                        outlined
                        @click="handleTryAgain"
                    >
                        Try again
                    </a-button>
                </b-message>
            </div>
        </a-card>

        <div class="flex justify-center w-full mt-32 text-primary">
            △△△
        </div>

    </div>
</template>

<script>
import axios from 'axios';
import isUserScrolling from '../../components/mixins/isUserScrolling';

const LOADING = 0;
const LOADED = 1;
const HAS_ERROR = 2;

export default {
    name: 'examples',

    mixins: [isUserScrolling],

    metaInfo() {
        return { title: 'Examples' };
    },

    data() {
        return {
            state: LOADING,
            categories: [],
            examples: [],
        };
    },

    computed: {
        isLoading() {
            return (this.state === LOADING);
        },

        isLoaded() {
            return (this.state === LOADED);
        },

        hasError() {
            return (this.state === HAS_ERROR);
        },

    },

    watch: {
        $route(to, from) { // eslint-disable-line no-unused-vars
            return this.fetchAllExamples();
        },
    },

    mounted() {
        this.fetchAllExamples();
    },

    methods: {
        handleScrollDown() {
            return window.scrollTo({
                top: window.innerHeight / 2,
                behavior: 'smooth',
            });
        },

        async fetchAllExamples() {
            try {
                const [categories, examples] = await Promise.all([
                    axios.get(route('public.categories.list')),
                    axios.get(route('public.examples.list'), {
                        params: {
                            'filter[category.slug]': this.$route.params.category,
                        },
                    }),
                ]);

                this.categories = categories.data.categories;
                this.examples = examples.data.examples;

                this.state = LOADED;
            } catch (err) {
                this.state = HAS_ERROR;
                throw new Error(`list-examples# Problem fetching data: ${err}`);
            }
        },

        handleTryAgain() {
            return this.fetchAllExamples();
        },

    },

};
</script>
