<template>
    <ul
        class="a-ul"
        :style="{
            // light: text-white
            // dark: text-grey-800
            color: light ? white : grey800,
        }"
    >
        <slot></slot>
    </ul>
</template>

<script>
import tailwind from '../../../../tailwind.config';

const grey800 = tailwind.theme.colors['grey-800'];
const { white } = tailwind.theme.colors;

export default {
    name: 'a-unordered-list',

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
        return {
            grey800,
            white,
        };
    },

    computed: {},

    methods: {},

};
</script>

<style>
.a-ul {
    position: relative;
    display: flex;
    flex-direction: column;
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.a-ul li {
    text-align: left;
    white-space: nowrap;
}

.a-ul li:before {
    content: '△';
    font-size: 10px;
    margin-top: 0.4rem;
    padding-right: 0.8rem;

}
</style>
