<template>
    <div class="relative flex flex-col items-center justify-end flex-1">
        <!-- {(+currentScrollYPosition === 0) && this.renderDownScroller()} -->
        <div
            id="examples"
            title="Examples"
            description="Examples from Adam Mackintosh"
        >
            active category: {{ activeCategorySlug }}<br>
            state: {{ state }}<br>

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
        </div>

    </div>
</template>

<script>
const LOADING = 0;
const SHOW_ALL_CATEGORIES = 1;
const SHOW_SINGLE_CATEGORY = 2;

// https://github.com/nicolasbeauvais/vue-social-sharing
export default {
    name: 'list-examples',

    props: {},

    data() {
        return {
            state: LOADING,
            categories: [],
            examples: [],
            activeCategorySlug: '',
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

    },

    watch: {
        $route(to, from) {
            this.setActiveCategory();
        },
    },

    mounted() {
        this.fetchData();
    },

    methods: {
        setActiveCategory() {
            if (this.$route.params.categorySlug) {
                this.activeCategorySlug = this.$route.params.categorySlug;
                this.state = SHOW_SINGLE_CATEGORY;
            } else {
                this.activeCategorySlug = '';
                this.state = SHOW_ALL_CATEGORIES;
            }
        },

        async fetchData() {
            try {
                const [categories, examples] = await Promise.all([
                    axios.get('/api/categories'),
                    axios.get('/api/examples', {
                        params: {
                            'filter[category.slug]': this.$route.params.categorySlug,
                        },
                    }),
                ]);

                // console.log('categories', categories.data);
                // console.log('examples', examples.data);

                this.categories = categories.data;
                this.examples = examples.data;

                this.setActiveCategory();
            } catch (err) {
                throw new Error(`list-examples# Problem fetching data: ${err}`);
            }
        },

    },

};
</script>

<style>
#examples {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 12.8rem;
    width: 100%;
    z-index: 0;
}

#examples-downScroller {
    position: absolute;
    right: 0;
    bottom: 0;
    width: 6.4rem;
    height: 6.4rem;
    font-size: 3.2rem;
    margin: 0 3.2rem 3.2rem 0;
    color: #8B4513;
    border: 0.2rem solid #8B4513;
    background: none;
    outline: #212121;
    transition: all 250ms ease-in-out;
    z-index: 1;
}

#examples-downScroller:hover {
    color: #66FCF1;
    border: 0.2rem solid #66FCF1;
    transition: all 250ms ease-in-out; }

#examples-downScroller:active {
    color: #FF5043;
    border: 0.2rem solid #FF5043;
}

#examples_grid {
    position: relative;
    display: flex;
    flex-direction: row;
    justify-content: center;
    flex-wrap: wrap;
    max-width: 140.0rem;
    height: 100%;
}

#examples_categories {
    position: relative;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    max-width: 53.0rem;
    padding-bottom: 3.2rem;
}

.examples_categories-button {
    font-family: 'Oswald', sans-serif;
    font-size: 1.6rem;
    line-height: 1.6rem;
    font-weight: 200;
    letter-spacing: 0.2em;
    text-align: center;
    text-decoration: none;
    background: none;
    color: #fff;
    border: 0.1rem solid #fff;
    padding: 1.6rem;
    margin: 0 0.8rem 1.6rem 0.8rem;
    transition: all 200ms ease-in-out;
}

.examples_categories-button:hover {
    color: #212121;
    background-color: #66FCF1;
    border: 0.1rem solid #66FCF1;
    transition: all 250ms ease-in-out;
}

.examples_categories-button:active {
    background-color: #45A29E;
    border: 0.1rem solid #45A29E;
}

.isActiveCategory {
    font-weight: 400;
    color: #212121;
    background-color: #66FCF1;
    border: 0.1rem solid #66FCF1;
}

.examples_grid_feature-button {
    width: 48.0rem;
    height: 27.0rem;
    padding: 0;
    margin: 0;
    border: none;
    margin: 3.2rem;
}

.examples_grid_feature-photo {
    position: relative;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: left top;
    width: 48.0rem;
    height: 27.0rem;
    border: 0.2rem solid #000;
    box-shadow: -8px 14px 40px 0px black;
}

.examples_grid_feature-photo:active {
    border: 0.2rem solid #66FCF1;
}

.examples_grid_feature-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.examples_grid_feature-caption {
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-content: center;
    width: 100%;
    text-align: center;
    font-family: 'Oswald', sans-serif;
    font-weight: 200;
    font-size: 1.6rem;
    line-height: 2.2rem;
    letter-spacing: 0.2em;
    color: #fff;
    background-color: rgba(51, 51, 51, 0.8);
    border: 0.1rem solid green;
    padding: 1.6rem;
}

.examples_grid_feature-unseen {
    display: none;
}

.examples_grid_feature-seen {
    position: relative;
    width: 100%;
    height: 100%;
}

.examples_grid_feature-seen span {
    display: flex;
    justify-content: center;
    align-content: center;
    height: 100%;
    text-align: center;
    font-family: 'Oswald', sans-serif;
    font-size: 4.8rem;
    line-height: 1.6rem;
    color: green;
    background-color: rgba(51, 51, 51, 0.8);
    border: 0.1rem solid green;
    padding: 1.6rem;
}

@media (max-width: 1337px) {
    #examples_grid {
        flex-direction: column;
    }
}

@media (max-width: 1024px) {
    #examples {
        padding-top: 22.4rem;
    }
}

@media (max-width: 600px) {
    #examples {
        padding-top: 27.2rem;
    }
    .examples_grid_feature-button {
        width: 32.0rem;
        height: 18.0rem;
    }
    .examples_grid_feature-photo {
        width: 32.0rem;
        height: 18.0rem;
    }
    #examples-conclusion {
        display: none;
    }
}







@media (max-width: 1650px) {
    #example_heading {
        font-size: 4.8rem;
        line-height: 6.4rem;
    }
    .example_header-photo {
        width: 32.0rem;
        height: 18.0rem;
    }
    .example_content-paragraph {
        max-width: 64.0rem;
    }
}

@media (max-width: 1337px) {
    #example-wrapper {
        padding: 12.8rem;
    }
    #example_header {
        flex-direction: column;
        align-items: center;
    }
    #example_header-left {
        width: 100%;
        padding-right: 6.4rem;
    }
    #example_heading {
        text-align: center;
        font-size: 4.8rem;
        line-height: 6.4rem;
    }
    #example_links {
        justify-content: center;
        margin-left: 0.8rem;
    }
    #example_header-right {
        width: 100%;
        justify-content: center;
        padding-left: 6.4rem;
    }
    .example_header-photo {
        width: 48.0rem;
        height: 27.0rem;
        margin-left: 0;
    }
}

@media (max-width: 1200px) {
    .example_content-half {
        flex-direction: column;
    }
    .example_content-split {
        width: 100%;
        align-items: center;
    }
    .example_content-subheading {
        text-align: center;
    }
    .example_content-paragraph {
        text-align: center;
    }
    #example_images {
        justify-content: center;
    }
    .example_content-full {
        align-items: center;
    }
}

@media (max-width: 1024px) {
    #example-wrapper {
        padding: 22.4rem 6.4rem 6.4rem 6.4rem;
    }
}

@media (max-width: 800px) {
    #example_header-left {
        padding: 3.2rem;
    }
    #example_header-right {
        padding: 3.2rem;
    }
    #example_heading {
        font-size: 4.0rem;
        line-height: 6.4rem;
    }
    .example_header-photo {
        width: 32.0rem;
        height: 18.0rem;
    }
}

@media (max-width: 650px) {
    #example_links {
        flex-direction: column;
        align-items: center;
    }
    .example_links-link {
        margin-top: 1.6rem;
    }
}

@media (max-width: 600px) {
    #example-wrapper {
        padding: 28.8rem 3.2rem 3.2rem 3.2rem;
    }
}

@media (max-width: 500px) {
    .examples_grid_feature-button {
        margin: 1.6rem 0 1.6rem 0;
    }
    #example-wrapper {
        padding: 28.8rem 1.6rem 1.6rem 1.6rem;
    }
    #example_header-left {
        padding: 1.6rem;
        padding-top: 4.0rem;
    }
    #example_header-right {
        padding: 1.6rem;
    }
    .example_content-subheading {
        padding: 6.4rem 1.6rem 3.2rem 1.6rem;
    }
    .example_content-paragraph {
        padding: 0 3.2rem 0 3.2rem;
    }
    #example_images {
        padding: 0;
    }
}
</style>
