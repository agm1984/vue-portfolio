<template>
    <div v-if="isLoaded" class="flex flex-col w-full h-auto xl:w-1024">
        <a-heading level="1" class="" dark>
            {{ example.name }}
        </a-heading>

        <div class="flex flex-row w-full h-auto">
            <div class="w-3/4 mr-16">
                <div class="flex flex-row w-full">
                    <a-card class="p-32" with-geometry>
                        <a-heading level="2" class="mb-16">Summary</a-heading>

                        <a-paragraph>
                            {{ example.summary }}
                        </a-paragraph>
                    </a-card>
                </div>

                <a-card class="p-32 mt-16" with-geometry>
                    <a-heading level="2">Images</a-heading>

                    <div class="flex flex-row flex-wrap justify-start">
                        <router-link
                            v-for="image in example.images"
                            :key="image.image_id"
                            :to="{ name: 'public.examples.images', params: { filename: image.filename } }"
                            class="relative m-16 bg-no-repeat bg-cover cursor-pointer border-1 border-primary w-256 h-128"
                            title="Click to enlarge"
                            :style="{ backgroundImage: `url('/storage/examples/${example.slug}/${image.filename}')` }"
                        ></router-link>
                    </div>
                </a-card>

                <a-card class="p-32 mt-16" with-geometry>
                    <a-heading level="2" class="mb-16">Conclusion</a-heading>

                    <a-paragraph>
                        {{ example.conclusion }}
                    </a-paragraph>
                </a-card>

                <div class="flex justify-center w-full mt-32 text-primary">
                    △△△
                </div>

            </div>

            <div class="w-1/4 ml-16">
                <a-card class="p-32" with-geometry>
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

                <a-card class="p-32 mt-16" with-geometry>
                    <a-heading level="2" class="mb-16">Tags</a-heading>

                    <a-unordered-list>
                        <li v-for="tag in example.tags" :key="`tag-${tag.name}`">
                            {{ tag.name }}
                        </li>
                    </a-unordered-list>
                </a-card>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

const IS_LOADING = 0;
const IS_LOADED = 1;

export default {
    name: 'show-example',

    middleware: ['auth', 'role-admin'],

    props: {},

    data() {
        return {
            state: IS_LOADING,
            category_id: 1,
            feature_id: 2,
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
.is-active .al img {
    filter: grayscale(0%);
}

.al img {
    filter: grayscale(100%);
}

#example-wrapper {
    display: flex;
    justify-content: center;
    width: 100%;
    padding: 12.8rem 19.2rem 12.8rem 19.2rem;
    /* z-index: -1; */
}

#example_line {
    position: absolute;
    display: inline-block;
    top: 6.4rem;
    left: -3.2rem;
    width: 6.4rem;
    height: 0.4rem;
    background-color: #fff;
    z-index: 9999;
}

#example {
    position: relative;
    width: 100%;
    background-color: #fff;
    padding-bottom: 6.4rem;
    /* z-index: -1; */
}

#example_header {
    position: relative;
    display: flex;
    flex-direction: row;
    background-color: rgba(25, 25, 25, 0.9);
    border: 0.1rem solid #fff;
    /* z-index: 0; */
}

#example_header-left {
    display: flex;
    flex-direction: column;
    width: 50%;
    margin: 0;
    padding: 6.4rem 0 6.4rem 6.4rem;
}

#example_heading {
    width: 100%;
    display: block;
    color: #FF5043;
    font-family: 'AROLY', sans-serif;
    font-size: 6.4rem;
    line-height: 8.0rem;
    margin: 0;
    padding-bottom: 3.2rem;
}

#example_links {
    display: flex;
    align-items: flex-end;
    width: 100%;
    height: 100%;
}

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
    transition: all 250ms ease-in-out;
}

.example_links-link:hover {
    color: #66FCF1;
    border: 0.1rem solid #66FCF1;
    transition: all 250ms ease-in-out;
}

.example_links-link:active {
    color: #FF5043;
    border: 0.1rem solid #FF5043;
    transition: all 125ms ease-in-out;
}

#example_header-right {
    display: flex;
    width: 50%;
    height: 100%;
    margin: 0;
    padding: 6.4rem 6.4rem 6.4rem 0rem;
}

.example_header-photo {
    display: block;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: left top;
    width: 48.0rem;
    height: 27.0rem;
    border: 0.2rem solid #212121;
    margin-left: 6.4rem;
}

.example_content-full {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    /* z-index: 0; */
}

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
    /* z-index: 9999; */
}

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
    /* z-index: 0; */
}

.example_content-half {
    position: relative;
    display: flex;
    flex-direction: row;
    /* z-index: 0; */
}

.example_content-split {
    width: 50%;
    display: flex;
    flex-direction: column;
    height: 100%;
}

#example_technologies-container {
    position: relative;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    padding-right: 6.4rem;
}



#example_images {
    display: flex;
    flex-direction: row;
    justify-content: center;
    flex-wrap: wrap;
    width: 100%;
    padding: 0 4.8rem 0 4.8rem;
}

.example_image {
    position: relative;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: left top;
    border: 0.1rem solid #212121;
    width: 32.0rem;
    height: 16.0rem;
    margin: 1.6rem;
    cursor: pointer;
}

.example_image:hover {
    border: 0.1rem solid #FF5043;
}

.example_image:active {
    border: 0.1rem solid #66FCF1;
}

.example_image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

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
    padding: 1.6rem;
}

.example_image-unseen {
    display: none;
}

.example_image-seen {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

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
    padding: 1.6rem;
}

#example_back-wrapper {
    position: relative;
    display: flex;
    justify-content: center;
}

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
    transition: all 250ms ease-in-out;
}

#example_back:hover {
    color: #FF5043;
    border: 0.1rem solid #FF5043;
    transition: all 250ms ease-in-out;
}

#example_back:active {
    color: #66FCF1;
    border: 0.1rem solid #66FCF1;
    transition: all 125ms ease-in-out;
}

#examples-footer {
    position: relative;
    display: flex;
    width: 100%;
    white-space: nowrap;
    padding: 3.2rem 0 3.2rem 0;
    user-select: none;
    z-index: 9999;
}

#examples-left {
    position: relative;
    display: flex;
    align-items: center;
    width: 19.2rem;
    padding-left: 3.2rem;
    z-index: 9999;
}

#examples-center {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

#examples-conclusion {
    font-family: 'Oswald', sans-serif;
    font-weight: 400;
    font-size: 1.6rem;
    line-height: 2.2rem;
    letter-spacing: 0.2em;
    color: #8B4513;
}

#examples-right {
    width: 19.2rem;
    height: 100%;
}
</style>
