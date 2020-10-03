<template>
    <div id="app">
        <loading ref="loading"></loading>

        <component :is="layout" v-if="layout"></component>

    </div>
</template>

<script>
import Loading from './Loading.vue';

/**
 * Layouts can be programmatically changed at run-time.
 *
 * The `default` layout shows the sacred-geometry wallpaper, top nav bar, and page content.
 * The `basic` layout shows only the page content.
 */
const layouts = {
    default: () => import('~/layouts/default.vue').then(m => m.default || m),
    basic: () => import('~/layouts/basic.vue').then(m => m.default || m),
};

export default {
    components: {
        Loading,
    },

    /**
     * Sets page meta info, such as default and page-specific page titles.
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
            console.log('did somethin');
        },

    },

};
</script>
