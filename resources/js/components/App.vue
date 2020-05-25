<template>
    <div id="app" class="flex flex-col w-full min-h-screen bg-black">
        <loading ref="loading"></loading>

        <transition name="page" mode="out-in">
            <component :is="layout" v-if="layout"></component>
        </transition>
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

    data() {
        return {
            layout: null,
            defaultLayout: 'default',
        };
    },

    metaInfo() {
        return {
            titleTemplate(titleChunk) {
                return titleChunk ? `${titleChunk} - Adam Mackintosh's Portfolio` : 'Adam Mackintosh\'s Portfolio';
            },
        };
    },

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
