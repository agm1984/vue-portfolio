<template>
    <a-card with-geometry>
        <!-- {(+currentScrollYPosition === 0) && this.renderDownScroller()} -->
        {{ categories }}
        <div id="examples_categories">
            <router-link
                to="/examples"
                class="examples_categories-button"
                activeClassName="isActiveCategory"
                tabindex="0"
                title="Show everything"
                exact
                @click="() => this.handleSetActiveCategory('viewAll')"
            >
                VIEW ALL
            </router-link>

            <router-link
                v-for="category in categories"
                :key="category.slug"
                :to="`/examples/${category.slug}`"
                class="examples_categories-button"
                activeClassName="isActiveCategory"
                tabindex="0"
                :title="`Show only ${category.name}`"
                @click="() => this.handleSetActiveCategory(category.slug)"
            >
                {{ category.name.toUpperCase() }}
            </router-link>
        </div>

        <div id="examples_grid">
            <router-link
                v-for="example in examples"
                :key="example.slug"
                :to="`/examples/${example.category.slug}/${example.slug}`"
                class="examples_grid_feature-button"
                @click="() => this.props.markExampleSeen(example.slug)"
            >
                <a-tilt>
                    <div
                        class="examples_grid_feature-photo"
                        :style="{ backgroundImage: `url(${example.image_url})` }"
                    >
                        <div class="examples_grid_feature-overlay">
                            <span class="examples_grid_feature-caption">
                                {{ example.name.toUpperCase() }}
                            </span>
                            <div
                                :class="(example.feature_seen === true) ? 'examples_grid_feature-seen' : 'examples_grid_feature-unseen'"
                            >
                                <span>✓</span>
                            </div>
                        </div>
                    </div>
                </a-tilt>
            </router-link>
        </div>

        <template v-if="true">
            <div id="examples-footer">
                <div id="examples-left">
                    <div class="nav_adamLogo"></div>
                    <span id="Nav_brand-adam">ADAM</span>
                    <span id="Nav_brand-mackintosh">MACKINTOSH</span>
                </div>
                <div id="examples-center">
                    <span id="examples-conclusion">△△△</span>
                </div>
                <div id="examples-right"></div>
            </div>
        </template>

        <button
            v-if="true"
            id="backToTopScroller"
            onClick={this.handleScrollBackToTop}
            title="Back to top?"
        >
            ⇧
        </button>
    </a-card>
</template>

<script>
import axios from 'axios';

const LOADING = 0;
const SHOW_ALL_CATEGORIES = 1;
const SHOW_SINGLE_CATEGORY = 2;
const SHOW_NETWORK_ERRORS = 3;

export default {
    name: 'examples',

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
            return this.setActiveCategory();
        },
    },

    mounted() {
        this.fetchAllExamples();
    },

    methods: {
        setActiveCategory() {
            if (this.$route.params.categorySlug) {
                this.activeCategory = this.categories.find(category => category.slug === this.$route.params.categorySlug);
                this.state = SHOW_SINGLE_CATEGORY;
            } else {
                this.activeCategory = {};
                this.state = SHOW_ALL_CATEGORIES;
            }
        },

        async fetchAllExamples() {
            try {
                const [categories, examples] = await Promise.all([
                    axios.get(route('admin.categories.list')),
                    axios.get(route('admin.examples.list'), {
                        params: {
                            'filter[category.slug]': this.$route.params.categorySlug,
                        },
                    }),
                ]);

                console.log('categories', categories.data);
                console.log('examples', examples.data);

                this.categories = categories.data;
                this.examples = examples.data;

                return this.setActiveCategory();
            } catch (err) {
                this.state = SHOW_NETWORK_ERRORS;
                throw new Error(`list-examples# Problem fetching data: ${err}`);
            }
        },

    },

};
</script>
