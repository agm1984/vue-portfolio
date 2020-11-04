<template>
    <div
        class="block"
        :style="{
            // light: text-white
            // dark: text-grey-800
            color: light ? '#ffffff' : '#2d3748',
        }"
    >
        <!-- paragraph content -->
        <slot></slot>

    </div>
</template>

<script>
/**
 * Standardizes paragraphs:
 * https://bulma.io/documentation/elements/block/
 *
 */
export default {
    name: 'a-paragraph',

    props: {
        light: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        dark: {
            type: Boolean,
            required: false,
            default: () => true,
        },
    },

    data() {
        return {};
    },

    computed: {},

    methods: {},

};
</script>
