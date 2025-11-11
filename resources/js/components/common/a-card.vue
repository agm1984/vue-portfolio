<template>
    <div
        :class="containerStyles"
        :style="{
            backgroundColor: primary ? '#006666' : undefined,
            boxShadow: '5px 5px 15px 0px rgba(50, 50, 50, 0.32)'
        }"
    >
        <a-sacred-geometry v-if="withGeometry" :id="id"></a-sacred-geometry>

        <!-- card content -->
        <slot></slot>

    </div>
</template>

<script>
import generateUuid from '../utils/generateUniqueId';

export default {
    name: 'a-card',

    props: {
        withGeometry: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        id: {
            type: String,
            required: false,
            default: generateUuid,
        },

        fill: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        light: {
            type: Boolean,
            required: false,
            default: () => true,
        },

        dark: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        primary: {
            type: Boolean,
            required: false,
            default: () => false,
        },

    },

    data() {
        return {};
    },

    computed: {
        containerStyles() {
            const styles = ['relative h-auto rounded-xl'];

            if (this.fill) styles.push('w-full');

            if (this.light) styles.push('bg-white');
            else if (this.dark) styles.push('dark-card');

            return styles;
        },

    },

    methods: {},

};
</script>
