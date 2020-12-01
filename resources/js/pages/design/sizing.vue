<template>
    <a-card id="design-system-typography" class="p-32" with-geometry>

        <a-heading level="1" dark>Space & Size</a-heading>

        <a-paragraph>
            This site uses primarily factors of 2, 4, 8, 16, 32, 64 for sizing. This relates loosely to the golden ratio 1.618~
            and to Fibonacci, in which the first few numbers are 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233. This is important
            because the first few numbers divisible by 16 are: 16, 32, 64, 96, 128, 256. Proportions tend to be
            pleasant when size dimensions are selected along this approximate range.
        </a-paragraph>

        <a-heading level="2" class="mt-32" dark>Sizing units</a-heading>

        <a-heading level="3" primary nunito>6.4rem</a-heading>
        <div class="w-64 h-64 border-black border-dashed border-1"></div>

        <a-heading level="3" class="mt-16" primary nunito>3.2rem</a-heading>
        <div class="w-32 h-32 border-black border-dashed border-1"></div>

        <a-heading level="3" class="mt-16" primary nunito>1.6rem</a-heading>
        <div class="w-16 h-16 border-black border-dashed border-1"></div>

        <a-heading level="3" class="mt-16" primary nunito>0.8rem</a-heading>
        <div class="w-8 h-8 border-black border-dashed border-1"></div>

        <a-heading level="3" class="mt-16" primary nunito>0.4rem</a-heading>
        <div class="w-4 h-4 border-black border-dashed border-1"></div>

    </a-card>
</template>

<script>
export default {
    name: 'sizing',

    data() {
        return {};
    },

    computed: {},

    methods: {},

};
</script>
