<template>
    <a-page class="relative z-0">
        <top-nav-bar></top-nav-bar>

        <div class="container w-full mt-32">
            <child></child>
        </div>

        <a-sacred-geometry-three></a-sacred-geometry-three>
    </a-page>
</template>

<script>
import TopNavBar from './top-nav-bar.vue';

export default {
    name: 'default',

    components: {
        TopNavBar,
    },
};
</script>
