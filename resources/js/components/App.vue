<template>
    <div id="app">
        TEST
        <div class="text-red-400 text-xl">test</div>
        <loading-bar ref="loading"></loading-bar>

        <!-- <component :is="layout" v-if="layout"></component> -->

    </div>
</template>

<script>
import LoadingBar from './loading-bar.vue';

/**
 * Layouts can be programmatically changed at run-time.
 *
 * The `default` layout shows the sacred-geometry wallpaper, top nav bar, and page content.
 * The `basic` layout shows only the page content.
 */
const layouts = {
    default: () => import('~/layouts/default.vue'),
    basic: () => import('~/layouts/basic.vue'),
};

export default {
    components: {
        LoadingBar,
    },

    /**
     * Sets page meta info, such as default and page-specific page titles.
     * To set page-specific titles, see:
     * https://stackoverflow.com/questions/51921546/vuejs-and-dynamic-titles/64326431#64326431
     */
    metaInfo() {
        return {
            titleTemplate(titleChunk) {
                const suffix = "Adam Mackintosh's Portfolio";
                return titleChunk ? `${titleChunk} - ${suffix}` : suffix;
            },
        };
    },

    data() {
        return {
            layout: null,
            defaultLayout: 'default',
        };
    },

    computed: {},

    mounted() {
        this.$loading = this.$refs.loading;
    },

    methods: {
        /**
         * Set the application layout.
         *
         * @param {String} layout
         * @return {Void}
         */
        setLayout(layout) {
            if (!layout || !layouts[layout]) {
                layout = this.defaultLayout;
            }

            this.layout = layouts[layout];
        },

    },

};
</script>
