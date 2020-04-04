<template>
    <div class="relative flex flex-col items-center justify-end flex-1">
        <!-- {(+currentScrollYPosition === 0) && this.renderDownScroller()} -->
        <div
            id="examples"
            title="Examples"
            description="Examples from Adam Mackintosh"
        >
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
                <template v-for="category in categories">
                    <router-link
                        :key="category.name"
                        :to="`/examples/${category.name}`"
                        class="examples_categories-button"
                        activeClassName="isActiveCategory"
                        tabindex="0"
                        :title="`Show only ${category.name}`"
                        @click="() => this.handleSetActiveCategory(category.name)"
                    >
                        {{ category.name.toUpperCase() }}
                    </router-link>
                </template>
            </div>

            <div id="examples_grid">
                <router-link
                    v-for="example in examples"
                    :key="example.name"
                    :to="`/examples/${example.category_id}/${example.name}`"
                    class="examples_grid_feature-button"
                    @click="() => this.props.markExampleSeen(example.name)"
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
// https://github.com/nicolasbeauvais/vue-social-sharing
export default {
    name: 'examples',

    props: {},

    data() {
        return {
            categories: [],
            examples: [],
        };
    },

    computed: {},

    mounted() {
        console.log('mounted');
        this.fetchStuff();
    },

    methods: {
        async fetchStuff() {
            try {
                const categories = await axios.get('/api/categories');
                const examples = await axios.get('/api/examples');

                console.log('categories', categories.data);
                console.log('examples', examples.data);

                this.categories = categories.data;
                this.examples = examples.data;
            } catch (err) {
                throw new Error(`examples# Problem fetching stuff: ${err}`);
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
  z-index: 0; }

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
  z-index: 1; }

#examples-downScroller:hover {
  color: #66FCF1;
  border: 0.2rem solid #66FCF1;
  transition: all 250ms ease-in-out; }

#examples-downScroller:active {
  color: #FF5043;
  border: 0.2rem solid #FF5043; }

#examples_grid {
  position: relative;
  display: flex;
  flex-direction: row;
  justify-content: center;
  flex-wrap: wrap;
  max-width: 140.0rem;
  height: 100%; }

#examples_categories {
  position: relative;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  max-width: 53.0rem;
  padding-bottom: 3.2rem; }

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
  transition: all 200ms ease-in-out; }

.examples_categories-button:hover {
  color: #212121;
  background-color: #66FCF1;
  border: 0.1rem solid #66FCF1;
  transition: all 250ms ease-in-out; }

.examples_categories-button:active {
  background-color: #45A29E;
  border: 0.1rem solid #45A29E; }

.isActiveCategory {
  font-weight: 400;
  color: #212121;
  background-color: #66FCF1;
  border: 0.1rem solid #66FCF1; }

.examples_grid_feature-button {
  width: 48.0rem;
  height: 27.0rem;
  padding: 0;
  margin: 0;
  border: none;
  margin: 3.2rem; }

.examples_grid_feature-photo {
  position: relative;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: left top;
  width: 48.0rem;
  height: 27.0rem;
  border: 0.2rem solid #000;
  box-shadow: -8px 14px 40px 0px black; }

.examples_grid_feature-photo:active {
  border: 0.2rem solid #66FCF1; }

.examples_grid_feature-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%; }

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
  padding: 1.6rem; }

.examples_grid_feature-unseen {
  display: none; }

.examples_grid_feature-seen {
  position: relative;
  width: 100%;
  height: 100%; }

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
  padding: 1.6rem; }

@media (max-width: 1337px) {
  #examples_grid {
    flex-direction: column; } }

@media (max-width: 1024px) {
  #examples {
    padding-top: 22.4rem; } }

@media (max-width: 600px) {
  #examples {
    padding-top: 27.2rem; }
  .examples_grid_feature-button {
    width: 32.0rem;
    height: 18.0rem; }
  .examples_grid_feature-photo {
    width: 32.0rem;
    height: 18.0rem; }
  #examples-conclusion {
    display: none; } }

#example-wrapper {
  position: relative;
  display: flex;
  justify-content: center;
  width: 100%;
  padding: 12.8rem 19.2rem 12.8rem 19.2rem;
  z-index: -1; }

#example_line {
  position: absolute;
  display: inline-block;
  top: 6.4rem;
  left: -3.2rem;
  width: 6.4rem;
  height: 0.4rem;
  background-color: #fff;
  z-index: 9999; }

#example {
  position: relative;
  width: 100%;
  background-color: #fff;
  padding-bottom: 6.4rem;
  z-index: -1; }

#example_header {
  position: relative;
  display: flex;
  flex-direction: row;
  background-color: rgba(25, 25, 25, 0.9);
  border: 0.1rem solid #fff;
  z-index: 0; }

#example_header-left {
  display: flex;
  flex-direction: column;
  width: 50%;
  margin: 0;
  padding: 6.4rem 0 6.4rem 6.4rem; }

#example_heading {
  width: 100%;
  display: block;
  color: #FF5043;
  font-family: 'AROLY', sans-serif;
  font-size: 6.4rem;
  line-height: 8.0rem;
  margin: 0;
  padding-bottom: 3.2rem; }

#example_links {
  display: flex;
  align-items: flex-end;
  width: 100%;
  height: 100%; }

.example_links-link {
  display: inline-block;
  font-family: 'Oswald', sans-serif;
  font-size: 1.6rem;
  line-height: 1.6rem;
  font-weight: 200;
  letter-spacing: 0.2em;
  text-decoration: none;
  white-space: nowrap;
  color: #fff;
  outline: none;
  background: none;
  margin-right: 1.6rem;
  padding: 1.6rem;
  border: 0.1rem solid #fff;
  transition: all 250ms ease-in-out; }

.example_links-link:hover {
  color: #66FCF1;
  border: 0.1rem solid #66FCF1;
  transition: all 250ms ease-in-out; }

.example_links-link:active {
  color: #FF5043;
  border: 0.1rem solid #FF5043;
  transition: all 125ms ease-in-out; }

#example_header-right {
  display: flex;
  width: 50%;
  height: 100%;
  margin: 0;
  padding: 6.4rem 6.4rem 6.4rem 0rem; }

.example_header-photo {
  display: block;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: left top;
  width: 48.0rem;
  height: 27.0rem;
  border: 0.2rem solid #212121;
  margin-left: 6.4rem; }

.example_content-full {
  position: relative;
  display: flex;
  flex-direction: column;
  width: 100%;
  z-index: 0; }

.example_content-subheading {
  position: relative;
  width: 100%;
  font-family: 'AROLY', sans-serif;
  font-size: 3.2rem;
  line-height: 3.2rem;
  letter-spacing: 0.024em;
  color: rgba(25, 25, 25, 0.9);
  margin: 0;
  padding: 6.4rem 6.4rem 3.2rem 6.4rem;
  z-index: 9999; }

.example_content-paragraph {
  position: relative;
  max-width: 88.0rem;
  color: #000;
  background: rgba(255, 255, 255, 0.4);
  font-family: 'Roboto', sans-serif;
  font-weight: 300;
  font-size: 1.6rem;
  line-height: 2.4rem;
  letter-spacing: 0.1em;
  margin: 0;
  padding: 0 6.4rem 0 6.4rem;
  z-index: 0; }

.example_content-half {
  position: relative;
  display: flex;
  flex-direction: row;
  z-index: 0; }

.example_content-split {
  width: 50%;
  display: flex;
  flex-direction: column;
  height: 100%; }

#example_technologies-container {
  position: relative;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  padding-right: 6.4rem; }

.example_technologies {
  position: relative;
  display: flex;
  flex-direction: column;
  list-style-type: none;
  margin: 0;
  padding: 0; }

.example_technologies li {
  font-family: 'Oswald', sans-serif;
  font-weight: 400;
  font-size: 1.6rem;
  line-height: 2.2rem;
  letter-spacing: 0.2em;
  text-align: left;
  color: #000;
  margin: 0 0 0.4rem 0;
  padding-left: 6.4rem;
  white-space: nowrap; }

.example_technologies li:before {
  content: '△';
  color: #FF5043;
  padding-right: 0.8rem; }

#example_images {
  display: flex;
  flex-direction: row;
  justify-content: center;
  flex-wrap: wrap;
  width: 100%;
  padding: 0 4.8rem 0 4.8rem; }

.example_image {
  position: relative;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: left top;
  border: 0.1rem solid #212121;
  width: 32.0rem;
  height: 16.0rem;
  margin: 1.6rem;
  cursor: pointer; }

.example_image:hover {
  border: 0.1rem solid #FF5043; }

.example_image:active {
  border: 0.1rem solid #66FCF1; }

.example_image-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%; }

.example_image-caption {
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
  padding: 1.6rem; }

.example_image-unseen {
  display: none; }

.example_image-seen {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%; }

.example_image-seen span {
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
  padding: 1.6rem; }

#example_back-wrapper {
  position: relative;
  display: flex;
  justify-content: center; }

#example_back {
  position: relative;
  font-family: 'Oswald', sans-serif;
  font-size: 1.6rem;
  line-height: 1.6rem;
  font-weight: 200;
  letter-spacing: 0.2em;
  color: #000;
  outline: none;
  background: none;
  padding: 1.6rem;
  border: 0.1rem solid #000;
  transition: all 250ms ease-in-out; }

#example_back:hover {
  color: #FF5043;
  border: 0.1rem solid #FF5043;
  transition: all 250ms ease-in-out; }

#example_back:active {
  color: #66FCF1;
  border: 0.1rem solid #66FCF1;
  transition: all 125ms ease-in-out; }

#examples-footer {
  position: relative;
  display: flex;
  width: 100%;
  white-space: nowrap;
  padding: 3.2rem 0 3.2rem 0;
  user-select: none;
  z-index: 9999; }

#examples-left {
  position: relative;
  display: flex;
  align-items: center;
  width: 19.2rem;
  padding-left: 3.2rem;
  z-index: 9999; }

#examples-center {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center; }

#examples-conclusion {
  font-family: 'Oswald', sans-serif;
  font-weight: 400;
  font-size: 1.6rem;
  line-height: 2.2rem;
  letter-spacing: 0.2em;
  color: #8B4513; }

#examples-right {
  width: 19.2rem;
  height: 100%; }

@media (max-width: 1650px) {
  #example_heading {
    font-size: 4.8rem;
    line-height: 6.4rem; }
  .example_header-photo {
    width: 32.0rem;
    height: 18.0rem; }
  .example_content-paragraph {
    max-width: 64.0rem; } }

@media (max-width: 1337px) {
  #example-wrapper {
    padding: 12.8rem; }
  #example_header {
    flex-direction: column;
    align-items: center; }
  #example_header-left {
    width: 100%;
    padding-right: 6.4rem; }
  #example_heading {
    text-align: center;
    font-size: 4.8rem;
    line-height: 6.4rem; }
  #example_links {
    justify-content: center;
    margin-left: 0.8rem; }
  #example_header-right {
    width: 100%;
    justify-content: center;
    padding-left: 6.4rem; }
  .example_header-photo {
    width: 48.0rem;
    height: 27.0rem;
    margin-left: 0; } }

@media (max-width: 1200px) {
  .example_content-half {
    flex-direction: column; }
  .example_content-split {
    width: 100%;
    align-items: center; }
  .example_content-subheading {
    text-align: center; }
  .example_content-paragraph {
    text-align: center; }
  #example_images {
    justify-content: center; }
  .example_content-full {
    align-items: center; } }

@media (max-width: 1024px) {
  #example-wrapper {
    padding: 22.4rem 6.4rem 6.4rem 6.4rem; } }

@media (max-width: 800px) {
  #example_header-left {
    padding: 3.2rem; }
  #example_header-right {
    padding: 3.2rem; }
  #example_heading {
    font-size: 4.0rem;
    line-height: 6.4rem; }
  .example_header-photo {
    width: 32.0rem;
    height: 18.0rem; } }

@media (max-width: 650px) {
  #example_links {
    flex-direction: column;
    align-items: center; }
  .example_links-link {
    margin-top: 1.6rem; } }

@media (max-width: 600px) {
  #example-wrapper {
    padding: 28.8rem 3.2rem 3.2rem 3.2rem; } }

@media (max-width: 500px) {
  .examples_grid_feature-button {
    margin: 1.6rem 0 1.6rem 0; }
  #example-wrapper {
    padding: 28.8rem 1.6rem 1.6rem 1.6rem; }
  #example_header-left {
    padding: 1.6rem;
    padding-top: 4.0rem; }
  #example_header-right {
    padding: 1.6rem; }
  .example_content-subheading {
    padding: 6.4rem 1.6rem 3.2rem 1.6rem; }
  .example_content-paragraph {
    padding: 0 3.2rem 0 3.2rem; }
  #example_images {
    padding: 0; } }
</style>
