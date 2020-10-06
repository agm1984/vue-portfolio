<template>
    <div :class="containerStyles">
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

    },

    data() {
        return {};
    },

    computed: {
        containerStyles() {
            const styles = ['relative h-auto p-32'];

            if (this.light) styles.push('light-card');
            else if (this.dark) styles.push('dark-card');

            return styles;
        },

    },

    methods: {},

};
</script>
