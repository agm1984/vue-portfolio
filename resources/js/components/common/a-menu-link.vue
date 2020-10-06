<template>
    <router-link
        v-slot="{ href, route, navigate, isActive }"
        :to="to"
    >
        <b-menu-item
            label="Typography"
            :active="isActive"
        ></b-menu-item>
    </router-link>
</template>

<script>
export default {
    name: 'a-menu-link',

    props: {
        to: {
            type: Object,
            required: true,
        },

        isDisabled: {
            type: Boolean,
            required: false,
            default: () => false,
        },

    },

    data() {
        return {};
    },

    computed: {},

    methods: {},

};
</script>
