<template>
    <div class="flex flex-col w-full min-h-screen p-32 bg-black">
        <top-nav-bar></top-nav-bar>

        <transition name="fade" appear @after-enter="afterEnter">
            <router-view :key="$route.fullPath"></router-view>
        </transition>

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

    methods: {
        afterEnter() {
            return this.$root.$emit('scrollAfterEnter');
        },

    },

};
</script>
