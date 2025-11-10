<template>
    <div class="flex flex-col w-full h-auto p-8 xl:w-1024 xl:p-0">
        <a-card class="p-8">
            <h1 class="mb-16">About me</h1>

            <div class="flex flex-col h-auto md:flex-row">
                <div class="w-full mr-0 md:w-1/2 md:mr-16">
                    <p>
                        I'll keep this short. I've been programming for about four years (calc: current year minus 2017),
                        but I've been working with iOS, Android, and web apps since 2013. I would say I discovered my passion
                        for coding around that time. I'm an autodidact-type person. All I need is a topic and an impetus, and
                        I can start researching it. Google really is a magical thing.
                    </p>

                    <p>
                        My list of hobbies is quite short because my main hobby is programming. Beyond that,
                        I enjoy working out. I've been working out for the past 10 years. I didn't go to the gym much in 2019,
                        but I've been going again four times a week, and it feels great.
                    </p>

                    <p>
                        I have a 700 horsepower 1993 Toyota Supra, so when the engine isn't broken and it's clean,
                        you can find me out driving with my friends, listening to music, and finding new places to visit.
                    </p>

                    <p>
                        Check out my <router-link :to="{ name: 'contact' }">Contact</router-link> page.
                    </p>

                    <div class="flex flex-col pb-8 bg-grey-200">
                        <h2 level="4" class="px-16 py-8 bg-primary" nunito light>
                            Find me on social media
                        </h2>
                        <!-- <a-social-link class="pt-8 pl-16" network="twitter">Twitter</a-social-link> -->
                        <!-- <a-social-link class="pt-8 pl-16" network="github">GitHub</a-social-link> -->
                        <!-- <a-social-link class="pt-8 pl-16" network="stackoverflow">StackOverflow</a-social-link> -->
                        <!-- <a-social-link class="pt-8 pl-16" network="medium">Medium</a-social-link> -->
                    </div>
                </div>

                <div class="w-full mt-32 md:w-1/2 md:mt-0">
                    <img src="adam-center.png" class="w-full h-auto pl-0 md:pl-16" alt="">
                </div>
            </div>

        </a-card>

        <!-- <div class="w-full">
            <h2 level="3" class="mt-64 mb-32" nunito>A BRIEF WORD</h2>

            <div class="flex flex-col w-full xl:flex-row">
                <a-card class="order-1 p-8 mr-0 xl:mr-16" fill primary>
                    <h2 level="2" class="mb-16" light>
                        To programmers
                    </h2>

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

                <a-card class="order-2 p-8 mt-32 ml-0 xl:ml-16 xl:mt-0" fill with-geometry>
                    <h2 level="2" class="mb-16">To non-programmers</h2>

                    <div class="flex flex-col w-full">
                        <div class="w-full">
                            <h2 level="3" primary nunito>Work</h2>
                            <a-paragraph class="pr-32">
                                As a developer, I aim to write not only pragmatic and UX-enriched code but also empathetic and
                                thorough technical documentation. I am always curious to learn new tools and techniques.
                            </a-paragraph>
                        </div>

                        <div class="w-full mt-16">
                            <h2 level="3" primary nunito>Life</h2>
                            <a-paragraph class="pr-32">
                                I am introverted and creative and known for being light hearted, precise, and thorough. I decompress
                                from work by going to the gym and cooking nice meals for other people. I like the chemistry behind
                                balancing salty, sweet, sour, and hot.
                            </a-paragraph>
                        </div>

                        <div class="w-full mt-16">
                            <h2 level="3" primary nunito>Balance</h2>
                            <a-paragraph>
                                Fitness & nutrition has been a way of life for me for the past ten years. A healthy mind and
                                optimized metabolic processes both start with optimized nutrient-intake.
                            </a-paragraph>
                        </div>
                    </div>
                </a-card>
            </div>

        </div> -->

        <div class="flex justify-center w-full mt-32 text-primary">
            △△△
        </div>

    </div>
</template>

<script>
// import AdamScene from './adam-scene.vue';
// import isUserScrolling from '../../components/mixins/isUserScrolling';

export default {
    name: 'about-me',

    components: {
        // AdamScene,
    },

    // mixins: [isUserScrolling],

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

    },

};
</script>
