<template>
    <a-page id="default-layout" class="relative z-0">
        <a-sacred-geometry id="wallpaper" is-wallpaper></a-sacred-geometry>

        <top-nav-bar></top-nav-bar>

        <!-- page content -->
        <router-view></router-view>

    </a-page>
</template>

<script>
import TopNavBar from './top-nav-bar.vue';

export default {
    name: 'default',

    components: {
        TopNavBar,
    },

    data() {
        return {};
    },

    computed: {},

    mounted() {},

    methods: {},
};
</script>
