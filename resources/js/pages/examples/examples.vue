<template>
    <div class="w-full">
        <a-heading level="1" class="mb-16">
            Examples
        </a-heading>

        <button
            v-if="!isUserScrolling"
            class="absolute flex items-center justify-center w-64 h-64 text-white bg-primary"
            tabindex="0"
            title="Click or scroll down to see more"
            :style="{
                top: 'calc(100vh - 6.4rem)',
                right: '1.6rem',
            }"
            @click="handleScrollDown"
        >
            <span class="mt-4 text-lg">⇩</span>
        </button>

        <div class="flex items-center justify-center">
            <router-link
                :to="{ name: 'public.examples.list' }"
                class="p-8"
                active-class="isActiveCategory"
                tabindex="0"
                title="Show everything"
                exact
                @click="() => this.handleSetActiveCategory('viewAll')"
            >
                View all
            </router-link>

            <router-link
                v-for="category in categories"
                :key="category.slug"
                :to="{ name: 'public.examples.list', params: { category: category.slug } }"
                class="p-8 ml-8"
                active-class="isActiveCategory"
                tabindex="0"
                :title="`Show only ${category.name}`"
                @click="() => this.handleSetActiveCategory(category.slug)"
            >
                {{ category.name }}
            </router-link>
        </div>

        <a-card class="flex flex-wrap w-full mt-16">
            <router-link
                v-for="example in examples"
                :key="example.slug"
                :to="{ name: 'public.examples.show', params: { category: example.category.slug, example: example.slug } }"
                class="m-32"
            >
                <a-tilt>
                    <a-card class="">
                        <div
                            class="bg-no-repeat bg-cover h-256 w-448"
                            :style="{ backgroundImage: `url('/storage/examples/${example.slug}/${example.images[0].filename}')` }"
                        >
                            <div class="px-16 py-8 bg-transparent-grey">
                                <span class="text-white font-nunito">
                                    {{ example.name }}
                                </span>
                            </div>
                        </div>
                    </a-card>
                </a-tilt>
            </router-link>
        </a-card>

        <div class="flex justify-center w-full mt-32 text-primary">
            △△△
        </div>

        <div class="absolute" :style="{ right: '1.6rem' }">
            <button
                class="flex items-center justify-center w-64 h-64 text-white bg-primary"
                title="Back to top?"
                @click="handleScrollBackToTop"
            >
                <span class="mt-4 text-lg">⇧</span>
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import isUserScrolling from '../../components/mixins/isUserScrolling';

const LOADING = 0;
const SHOW_ALL_CATEGORIES = 1;
const SHOW_SINGLE_CATEGORY = 2;
const SHOW_NETWORK_ERRORS = 3;

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
            activeCategory: {},
        };
    },

    computed: {
        isInitializing() {
            return (this.state === LOADING);
        },

        isShowingAllCategories() {
            return (this.state === SHOW_ALL_CATEGORIES);
        },

        isShowingSingleCategory() {
            return (this.state === SHOW_SINGLE_CATEGORY);
        },

        isFetchError() {
            return (this.state === SHOW_NETWORK_ERRORS);
        },

        title() {
            return this.isShowingSingleCategory ? this.activeCategory.name : 'Examples';
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

        handleScrollBackToTop() {
            return window.scrollTo({
                top: 0,
                behavior: 'smooth',
            });
        },

        setActiveCategory() {
            if (this.$route.params.category) {
                this.activeCategory = this.categories.find(category => (category.slug === this.$route.params.category));
                this.state = SHOW_SINGLE_CATEGORY;
            } else {
                this.activeCategory = {};
                this.state = SHOW_ALL_CATEGORIES;
            }
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

                // console.log('categories', categories.data.categories);
                // console.log('examples', examples.data.examples);

                this.categories = categories.data.categories;
                this.examples = examples.data.examples;

                return this.setActiveCategory();
            } catch (err) {
                this.state = SHOW_NETWORK_ERRORS;
                throw new Error(`list-examples# Problem fetching data: ${err}`);
            }
        },

    },

};
</script>

<style>
    .isActiveCategory {
        color: #ffffff;
        background-color: #006666;
        border: 0.1rem solid #006666;
    }
</style>
