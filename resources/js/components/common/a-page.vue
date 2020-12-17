<template>
    <div
        class="flex flex-col items-center flex-1 pb-64 px:16 lg:px-32"
        style="background-image: radial-gradient(#e2e8f0, #edf2f7, #f7fafc);"
    >
        <!-- page -->
        <slot></slot>

    </div>
</template>

<script>
// http://hexcolor16.com/070d0d
export default {
    name: 'a-page',

    props: {},

    data() {
        return {};
    },

    computed: {},

    mounted() {},

    methods: {},

};
</script>
