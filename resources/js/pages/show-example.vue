<template>
    <div class="flex flex-col items-center flex-1 py-64 px-128">
        <div id="example">

            <div id="example_line"></div>

            <a-sacred-geometry
                circleColor="#FF5043"
                dotColor="#45A29E"
                lineColor="#C5C6C7"
                :extraStyles="{
                    position: 'absolute',
                    top: 0,
                    left: 0,
                    width: '100%',
                    height: '100%',
                    opacity: 0.2,
                    zIndex: -1,
                }"
            ></a-sacred-geometry>

            <div id="example_header">
                <div id="example_header-left">
                    <h2 id="example_heading">{{ example.name }}</h2>
                    <div id="example_links">
                        {feature_URL_primary.enabled && (
                        <a
                            class="example_links-link"
                            href={feature_URL_primary.url}
                            rel="noopener noreferrer"
                            title={feature_URL_primary.tooltip}
                            target="_blank"
                        >
                            {feature_URL_primary.label}
                        </a>
                        )}
                        {feature_URL_secondary.enabled && (
                        <a
                            class="example_links-link"
                            href={feature_URL_secondary.url}
                            rel="noopener noreferrer"
                            title={feature_URL_secondary.tooltip}
                            target="_blank"
                        >
                            {feature_URL_secondary.label}
                        </a>
                        )}
                        {feature_URL_tertiary.enabled && (
                        <a
                            class="example_links-link"
                            href={feature_URL_tertiary.url}
                            rel="noopener noreferrer"
                            title={feature_URL_tertiary.tooltip}
                            target="_blank"
                        >
                            {feature_URL_tertiary.label}
                        </a>
                        )}
                    </div>
                </div>
                <div id="example_header-right">
                    <div
                        class="example_header-photo"
                        :style="{ backgroundImage: `url('/adam.png')` }"
                        title="Scroll down to see more"
                    ></div>
                </div>
            </div>

            <div class="example_content-half">
                <div class="example_content-split">
                    <h3 class="example_content-subheading">summary</h3>

                    <p class="example_content-paragraph">
                        {{ example.summary }}
                    </p>
                </div>
                <div class="example_content-split">
                    <h3 class="example_content-subheading">technologies used</h3>

                    <div id="example_technologies-container">
                        <ul class="example_technologies">
                            <li v-for="primary in ['One', 'Two', 'Three']" :key="primary">
                                {{ primary }}
                            </li>
                        </ul>
                        <ul class="example_technologies">
                            <li v-for="secondary in ['Four', 'Five', 'Six']" :key="secondary">
                                {{ secondary }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="example_content-full">
                <h3 class="example_content-subheading">additional images</h3>
                <div id="example_images">
                    {feature_images.map(image => (
                    <router-link
                        key={image.image_id}
                        :to="`/examples/${category_id}/${feature_id}/${image.image_id}`"
                        class="example_image"
                        title="Click to enlarge"
                        :style="{ backgroundImage: `url('/adam.png')` }"
                        @click="() => props.markImageSeen({
                            feature_id,
                            image_id: image.image_id,
                        })"
                    >
                        <div
                            class="example_image-overlay"
                        >
                            <span class="example_image-caption">
                                {image.image_caption}
                            </span>
                            <div
                                :class="(image.image_seen === true) ? 'example_image-seen' : 'example_image-unseen'"
                            >
                                <span>✓</span>
                            </div>
                        </div>
                    </router-link>
                    ))}
                </div>
            </div>

            <div class="example_content-full">
                <h3 class="example_content-subheading">conclusion</h3>
                <p class="example_content-paragraph">
                    {{ example.conclusion }}
                </p>
            </div>

            <div id="story-footer">
                <div id="story-left"></div>
                <div id="story-center">
                    <span
                        id="story-conclusion"
                        :style="{ color: '#FF5043' }"
                    >
                        △△△
                    </span>
                </div>
                <div id="story-right"></div>
            </div>

            <div id="example_back-wrapper">
                <button
                    id="example_back"
                    @click="() => props.handleBackToExamples()"
                >
                    BACK
                </button>
            </div>
        </div>
    </div>
</template>

<script>
const IS_LOADING = 0;
const IS_LOADED = 1;

export default {
    name: 'show-example',

    props: {},

    data() {
        return {
            state: IS_LOADING,
            category_id: 1,
            feature_id: 2,
            image: {},
            example: {},
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
        console.log('example slug', this.$route.params.exampleSlug);
        this.fetchExample();
    },

    methods: {
        goBack() {
            return this.$router.go(-1);
        },

        async fetchExample() {
            try {
                const example = await axios.get(`/api/example/${this.$route.params.exampleSlug}`);

                console.log('example', example.data);

                this.example = example.data;

                this.state = IS_LOADED;
            } catch (err) {
                throw new Error(`show-example# Problem fetching example: ${err}`);
            }
        },
    },

};
</script>

<style>
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

.example_technologies {
    position: relative;
    display: flex;
    flex-direction: column;
    list-style-type: none;
    margin: 0;
    padding: 0;
}

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
    white-space: nowrap;
}

.example_technologies li:before {
    content: '△';
    color: #FF5043;
    padding-right: 0.8rem;
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
