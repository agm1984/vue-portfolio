<template>
    <div>
        <b-button
            ref="button"
            :tag="tag"
            :href="href"
            :type="type"
            :size="size"
            :disabled="disabled"
            :expanded="expanded"
            :loading="loading"
            :rounded="rounded"
            :inverted="inverted"
            :outlined="outlined"
            :icon-pack="iconPack"
            :icon-left="iconLeft"
            :icon-right="iconRight"
            :native-type="nativeType"
            @click="handleButtonClick"
        >
            <slot></slot>

        </b-button>
    </div>
</template>

<script>
export default {
    name: 'a-button',

    props: {
        type: {
            type: String,
            required: false,
            default: () => 'is-primary',
        },

        size: {
            type: String,
            required: false,
            default: () => 'is-default',
        },

        disabled: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        expanded: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        loading: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        rounded: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        inverted: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        outlined: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        iconPack: {
            type: String,
            required: false,
            default: () => 'fas',
        },

        iconLeft: {
            type: String,
            required: false,
            default: () => undefined,
        },

        iconRight: {
            type: String,
            required: false,
            default: () => undefined,
        },

        nativeType: {
            type: String,
            required: false,
            default: () => 'button',
        },

        tag: {
            type: String,
            required: false,
            default: () => 'button', // hint: tag="a" with href="/poop"
        },

        href: {
            type: String,
            required: false,
            default: () => undefined,
        },
    },

    data() {
        return {};
    },

    computed: {},

    watch: {},

    mounted() {},

    methods: {
        handleButtonClick() {
            return this.$emit('click');
        },

    },

};
</script>
