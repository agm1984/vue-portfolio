<template>
    <div class="flex flex-col w-full h-auto xl:w-1024">
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

        <a-card class="p-32">
            <a-heading level="1" class="mb-16">About me</a-heading>

            <div class="flex flex-row h-auto">
                <div class="w-1/2">
                    <a-paragraph>
                        I'll keep this short. I've been programming for about four years (calc: current year minus 2017),
                        but I've been working with iOS, Android, and web apps since 2013. I would say I discovered my passion
                        for coding around that time. I'm an autodidact-type person. All I need is a topic and an impetus, and
                        I can start researching it. Google really is a magical thing.
                    </a-paragraph>

                    <a-paragraph>
                        My list of hobbies is quite short because my main hobby is programming. Beyond that,
                        I enjoy working out. I've been working out for the past 10 years. I didn't go to the gym much in 2019,
                        but I've been going again four times a week, and it feels great.
                    </a-paragraph>

                    <a-paragraph>
                        I have a 700 horsepower 1993 Toyota Supra, so when the engine isn't broken and it's clean,
                        you can find me out driving with my friends, listening to music, and finding new places to visit.
                    </a-paragraph>

                    <a-paragraph>
                        Check out my <router-link :to="{ name: 'contact' }">Contact</router-link> page.
                    </a-paragraph>

                    <div class="flex flex-col pb-8 bg-grey-200">
                        <a-heading level="4" class="px-16 py-8 bg-primary" nunito light>
                            Find me on social media
                        </a-heading>
                        <a-social-link class="pt-8 pl-16" network="twitter">Twitter</a-social-link>
                        <a-social-link class="pt-8 pl-16" network="github">GitHub</a-social-link>
                        <a-social-link class="pt-8 pl-16" network="stackoverflow">StackOverflow</a-social-link>
                        <a-social-link class="pt-8 pl-16" network="medium">Medium</a-social-link>
                    </div>
                </div>

                <div class="flex flex-col items-start w-1/2">

                    <!-- <button @click="$root.$emit('animate-it')">Interact</button> -->
                    <adam-scene></adam-scene>
                </div>
            </div>

        </a-card>

        <div class="w-full">
            <a-heading level="3" class="mt-64 mb-32" nunito>A BRIEF WORD</a-heading>

            <div class="flex flex-col w-full xl:flex-row">
                <a-card class="order-1 p-32 mr-0 xl:mr-16" fill primary>
                    <a-heading level="2" class="mb-16" light>To programmers</a-heading>

                    <a-paragraph light>
                        What can I say? I like to use Mealy finite state machines, predicates and booleans,
                        and immutable functional-reactive programming (FRP) styles (ie: map, reduce, filter, etc).
                    </a-paragraph>

                    <a-paragraph light>
                        I often think in two modes: push and pull. Pushing is like doing & triggering.
                        Pulling is like listening & acting. In my opinion, this is much of where the
                        "functional-reactive" comes from in FRP. Functional can be pushing, and reactive can be pulling.
                    </a-paragraph>
                </a-card>

                <a-card class="order-2 p-32 mt-32 ml-0 xl:ml-16 xl:mt-0" fill>
                    <a-heading level="2" class="mb-16">To non-programmers</a-heading>

                    <div class="flex flex-col w-full">
                        <div class="w-full">
                            <a-heading level="3" primary nunito>Work</a-heading>
                            <a-paragraph class="pr-32">
                                As a developer, I aim to write not only pragmatic and UX-enriched code but also empathetic and
                                thorough technical documentation. I am always curious to learn new tools and techniques.
                            </a-paragraph>
                        </div>

                        <div class="w-full mt-16">
                            <a-heading level="3" primary nunito>Life</a-heading>
                            <a-paragraph class="pr-32">
                                I am introverted and creative and known for being light hearted, precise, and thorough. I decompress
                                from work by going to the gym and cooking nice meals for other people. I like the chemistry behind
                                balancing salty, sweet, sour, and hot.
                            </a-paragraph>
                        </div>

                        <div class="w-full mt-16">
                            <a-heading level="3" primary nunito>Balance</a-heading>
                            <a-paragraph>
                                Fitness & nutrition has been a way of life for me for the past ten years. A healthy mind and
                                optimized metabolic processes both start with optimized nutrient-intake.
                            </a-paragraph>
                        </div>
                    </div>
                </a-card>
            </div>

        </div>

        <div class="flex justify-center w-full mt-32 text-primary">
            △△△
        </div>

        <!-- <div class="absolute" :style="{ right: '1.6rem' }">
            <button
                class="flex items-center justify-center w-64 h-64 text-white bg-primary"
                title="Back to top?"
                @click="handleScrollBackToTop"
            >
                <span class="mt-4 text-lg">⇧</span>
            </button>
        </div> -->
    </div>
</template>

<script>
import AdamScene from './adam-scene.vue';
import isUserScrolling from '../../components/mixins/isUserScrolling';

export default {
    name: 'about-me',

    components: {
        AdamScene,
    },

    mixins: [isUserScrolling],

    metaInfo() {
        return { title: 'About me' };
    },

    data() {
        return {};
    },

    computed: {},

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
    },

};
</script>

<style>
.timeline-title {
    position: relative;
    font-family: 'Oswald', sans-serif;
    font-size: 1.6rem;
    line-height: 1.6rem;
    font-weight: 200;
    letter-spacing: 0.2em;
    margin: 0;
    margin-bottom: 3.2rem;
}

.timeline-title:after {
    border-bottom: 1px solid #618396;
    display: block;
    height: 1px;
    margin: 0.625em auto 1.375em;
    max-width: 80px;
}

.timeline-bonusPadding {
    padding: 3.2rem 0 0 0;
}

#story-wrapper {
    position: relative;
    width: 100%;
    height: 100vh;
}

#timeline .timeline-item:after,
#timeline .timeline-item:before {
    content: '';
    display: block;
    width: 100%;
    clear: both;
}

#timeline {
    width: 100%;
    position: relative;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    -ms-transition: all 0.4s ease;
    transition: all 0.4s ease;
}

#timeline:before {
    content: '';
    position: absolute;
    width: 0.2rem;
    height: 100%;
    background: #8B4513;
    left: 50%;
    top: 0;
}

#timeline:after {
    content: '';
    clear: both;
    display: table;
    width: 100%;
}

#timeline .timeline-item {
    position: relative;
}

#timeline .timeline-item .timeline-icon {
    position: absolute;
    top: 0;
    left: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 6.4rem;
    height: 6.4rem;
    overflow: hidden;
    font-family: 'Oswald', sans-serif;
    font-size: 1.6rem;
    line-height: 1.6rem;
    font-weight: 400;
    letter-spacing: 0.2em;
    color: #fff;
    background: #014420;
    margin-left: -3.0rem;
    border-radius: 50%;
}

#timeline .timeline-item .timeline-content {
    width: 45%;
    font-family: 'Roboto', sans-serif;
    font-weight: 300;
    font-size: 1.6rem;
    line-height: 2.4rem;
    letter-spacing: 0.1em;
    text-align: center;
    background: none;
    padding: 3.2rem;
    box-shadow: 0 3px 0 rgba(0, 0, 0, 0.1);
    transition: all 250ms ease;
}

#timeline .timeline-item .timeline-content h2 {
    font-family: 'AROLY', sans-serif;
    font-size: 2.8rem;
    line-height: 2.8rem;
    letter-spacing: 0.1em;
    text-align: center;
    padding: 1.6rem;
    margin: -3.2rem -2.0rem 0 -1.6rem;
    color: #CCCCCC;
    background-color: rgba(51, 51, 51, 0.8);
    border: 0.1rem solid green;
}

#timeline .timeline-item .timeline-content:before {
    content: '';
    position: absolute;
    left: calc(45% - 1.2rem);
    top: 3.0rem;
    width: 4.0rem;
    height: 0;
    border-bottom: 0.4rem solid #8B4513;
    z-index: -1;
}

#timeline .timeline-item .timeline-content.right {
    float: right;
}

#timeline .timeline-item .timeline-content.right:before {
    content: '';
    right: calc(45% - 1.6rem);
    left: inherit;
    top: 3.0rem;
    width: 3.6rem;
    height: 0;
    border-bottom: 0.4rem solid #8B4513;
}

@media (max-width: 768px) {
    #timeline {
        margin: 3.2rem;
        padding: 0px;
        width: 90%;
    }
    #timeline:before {
        left: 0;
    }
    #timeline .timeline-item .timeline-content {
        width: 90%;
        float: right;
    }
    #timeline .timeline-item .timeline-content:before,
    #timeline .timeline-item .timeline-content.right:before {
        left: -1.6rem;
        margin-left: 4.0rem;
        width: 6.0rem;
        border-left: 0;
    }
    #timeline .timeline-item .timeline-icon {
        left: 0;
    }
}

@media (max-width: 668px) {
    #timeline .timeline-item .timeline-content:before,
    #timeline .timeline-item .timeline-content.right:before {
        margin-left: 3.2rem;
    }
}

@media (max-width: 568px) {
    #timeline .timeline-item .timeline-content:before,
    #timeline .timeline-item .timeline-content.right:before {
        margin-left: 2.2rem;
    }
}

@media (max-width: 468px) {
    #timeline .timeline-item .timeline-content:before,
    #timeline .timeline-item .timeline-content.right:before {
        margin-left: 1.6rem;
    }
}

@media (max-width: 368px) {
    #timeline .timeline-item .timeline-content:before,
    #timeline .timeline-item .timeline-content.right:before {
        margin-left: 0.4rem;
    }
}

#team-intro {
    max-width: 80.0rem;
    height: 80rem;
    font-family: 'Roboto', sans-serif;
    letter-spacing: 0.1rem;
    font-weight: 300;
    font-size: 1.6rem;
    line-height: 2.4rem;
    text-align: center;
}

#team-container-wrapper {
    width: 140.0rem;
}

#team-container {
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 100%;
    padding-top: 3.2rem;
}

.team_person {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 33.333%;
}

.team_person-avatar {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    width: 9.6rem;
    height: 9.6rem;
    border: 0.1rem solid #000;
    border-radius: 50%;
    box-shadow: -8px 14px 40px 0px black;
    margin-bottom: 3.2rem;
    opacity: 0.9;
}

.team_person-title {
    font-family: 'AROLY', sans-serif;
    font-size: 2.0rem;
    line-height: 2.0rem;
    font-weight: 200;
    letter-spacing: 0.1em;
    color: #FF5043;
    margin: 0;
}

.team_person-blurb {
    text-align: center;
    font-family: 'Roboto', sans-serif;
    letter-spacing: 0.1rem;
    font-weight: 300;
    font-size: 1.6rem;
    line-height: 2.4rem;
    margin-top: 0.8rem;
    margin-bottom: 6.4rem;
    padding: 0 3.2rem 0 3.2rem;
}

#info-wrapper {
    display: block;
    padding: 0 3.2rem 3.2rem 3.2rem;
    overflow: none;
}

#info-specialWrapper {
    width: 160.0rem;
}

#info-container {
    display: flex;
}

#info_split-container {
    display: flex;
    background-color: #004040;
    box-shadow: -8px 14px 40px 0px black;
    padding-bottom: 1.6rem;
}

.info_split {
    width: 50%;
    padding: 0;
}

#info_split-divider {
    width: 6.4rem;
    height: 1.6rem;
}

.info_split-title {
    text-align: center;
    font-family: 'AROLY', sans-serif;
    font-size: 2.0rem;
    line-height: 2.0rem;
    font-weight: 200;
    letter-spacing: 0.1em;
    color: #fff;
    background-color: rgba(51, 51, 51, 0.8);
    border: 0.1rem solid green;
    margin: 3.2rem 0 0 0;
    padding: 1.6rem;
}

.info_split-column {
    display: flex;
    flex-direction: column;
    text-align: center;
    padding: 1.6rem;
}

.info_split-heading {
    font-family: 'AROLY', sans-serif;
    font-size: 2.0rem;
    line-height: 2.8rem;
    font-weight: 200;
    letter-spacing: 0.1em;
    color: #339999;
    margin: 0;
    padding: 0;
}

.info_split-content {
    font-family: 'Roboto', sans-serif;
    letter-spacing: 0.1rem;
    font-weight: 300;
    font-size: 1.6rem;
    line-height: 2.4rem;
    margin: 0;
}

#programmers-container {
    padding: 0 0 0 0.4rem;
}

#path-wrapper {
    position: relative;
    display: block;
    width: calc(100vw - 3.2rem);
}

/*
  1.9rem is needed to maintain horizontal alignment
  with adjacent elements.
*/
#path-container {
    display: flex;
    justify-content: center;
    padding: 3.2rem 1.9rem 3.2rem 0;
}

.path-divider {
    width: 6.4rem;
    height: 6.4rem;
}

#story-footer {
    position: relative;
    display: flex;
    width: 100%;
    white-space: nowrap;
    padding: 3.2rem 0 3.2rem 0;
    user-select: none;
    z-index: 9999;
}

#story-left {
    position: relative;
    display: flex;
    align-items: center;
    width: 19.2rem;
    padding-left: 3.2rem;
    z-index: 9999;
}

#story-center {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

#story-conclusion {
    font-family: 'Oswald', sans-serif;
    font-weight: 400;
    font-size: 1.6rem;
    line-height: 2.2rem;
    letter-spacing: 0.2em;
    color: #8B4513;
}

#story-right {
    width: 19.2rem;
    height: 100%;
}

@media (max-width: 1664px) {
    #info-specialWrapper {
        width: 128.0rem;
    }
}

@media (max-width: 1400px) {
    #team-container-wrapper {
        width: 100%;
    }
    #team-container {
        flex-direction: column;
        align-items: center;
    }
    .team_person {
        width: 100%;
        max-width: 450px;
    }
    .btn {
        margin-bottom: 6.4rem;
    }
    #info-specialWrapper {
        width: 96.0rem;
    }
    #info_split-container {
        flex-direction: column;
    }
}

@media (max-width: 1024px) {
    #story {
        padding-top: 22.4rem;
        align-items: initial;
    }
    .timeline-title {
        text-align: center;
    }
    #info-specialWrapper {
        width: 100%;
    }
    #info-container {
        flex-direction: column;
        align-items: center;
    }
    .info_split {
        width: 100%;
        padding: 0 1.6rem 0 1.6rem;
    }
    #info_split-container {
        margin-bottom: 1.6rem;
    }
    #path-container {
        padding: 3.2rem 0 3.2rem 0;
    }
    .story_paragraph {
        text-align: center;
    }
}

@media (max-width: 600px) {
    #story {
        padding-top: 25.6rem;
    }
    .team_person {
        padding: 0 3.2rem 0 3.2rem;
    }
    #info-wrapper {
        padding: 0;
    }
    #story-conclusion {
        display: none;
    }
}
</style>
