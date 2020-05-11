<template>
    <a-page>
        <top-nav-bar></top-nav-bar>

        <div class="container mt-32">
            <child></child>
        </div>
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
