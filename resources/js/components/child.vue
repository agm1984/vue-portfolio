<template>
    <transition name="page" mode="out-in">
        <slot>
            <router-view></router-view>
        </slot>
    </transition>
</template>

<script>
export default {
    name: 'child',

    data() {
        return {};
    },

    computed: {},

    mounted() {},

    methods: {},

};
</script>
