<template>
    <div class="flex flex-col w-full min-h-screen p-32 bg-black">
        <top-nav-bar></top-nav-bar>

        <router-view></router-view>

    </div>
</template>

<script>
import TopNavBar from './TopNavBar.vue';

export default {
    name: 'app',

    components: {
        TopNavBar,
    },

    props: {},

    data() {
        return {};
    },

    computed: {},

    mounted() {},

    methods: {},

};
</script>
