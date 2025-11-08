<template>
    <div class="">

        <div class="relative">
            <div class="bg-no-repeat bg-cover rounded-full h-96 w-96 border-1 border-primary" style="background-image: url('/adam.png')"></div>

            <h2 level="3" class="mt-64 mb-32" nunito>
                THE PORTFOLIO OF
            </h2>

            <a-lambda class="absolute mt-0 -ml-0 lg:ml-8 lg:mt-28" :fill-hex="secondary" :size="32"></a-lambda>
            <h1 class="text-2xl lg:text-5xl font-aroly text-primary">
                Adam
            </h1>

            <h1 class="text-2xl lg:text-5xl font-aroly text-primary">
                Mackintosh
            </h1>
        </div>

    </div>
</template>

<script>
import tailwind from '../../../../tailwind.config';

const { secondary } = tailwind.theme.colors;

export default {
    name: 'home',

    metaInfo() {
        return { title: 'Home' };
    },

    data() {
        return {
            secondary,
        };
    },

    computed: {},

    methods: {},

};
</script>
