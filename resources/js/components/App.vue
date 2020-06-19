<template>
    <div id="app">
        <loading ref="loading"></loading>

        <component :is="layout" v-if="layout"></component>

    </div>
</template>

<script>
import Loading from './Loading.vue';

// load layout components dynamically
const requireContext = require.context('~/layouts', false, /.*\.vue$/);

const layouts = requireContext.keys()
    .map(file => [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)])
    .reduce((components, [name, component]) => {
        components[name] = component.default || component;
        return components;
    }, {});

export default {
    el: '#app',

    components: {
        Loading,
    },

    metaInfo() {
        return {
            titleTemplate(titleChunk) {
                return titleChunk ? `${titleChunk} - Adam Mackintosh's Portfolio` : "Adam Mackintosh's Portfolio";
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
