<template>
    <div class="flex items-center">
        <div class="w-20 h-20 mb-4 adam-logo"></div>

        <span class="leading-none logo__firstName font-aroly text-grey-500 text-md" style="margin-top: 0.3rem;">
            ADAM
        </span>

        <span class="ml-2 leading-none logo__lastName font-nunito text-primary-text text-md">
            MACKINTOSH
        </span>

    </div>
</template>

<script>
export default {
    name: 'adam-mackintosh-logo',

    data() {
        return {};
    },

    computed: {},

    methods: {},

};
</script>

<style>
@media screen and (max-width: 700px) {
    .logo__firstName {
        display: none;
    }

    .logo__lastName {
        display: none;
    }
}
</style>
