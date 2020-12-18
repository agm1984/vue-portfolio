<template>
    <div class="flex flex-col w-full min-h-screen p-32 bg-black">
        <!-- <top-nav-bar></top-nav-bar> -->

        <!-- TODO:  make it so non-logged-in users are encouraged to sign up -->
        <!-- <a-message>
            [info] You're currently viewing a course logged out. Sign in to your account or start a free trial.
        </a-message> -->

        <transition name="fade" appear @after-enter="afterEnter">
            <router-view :key="$route.fullPath"></router-view>
        </transition>

    </div>
</template>

<script>
// import TopNavBar from './top-nav-bar.vue';

export default {
    name: 'app',

    // components: {
    //     TopNavBar,
    // },

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
