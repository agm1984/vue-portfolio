<script setup>
</script>

<template>
    <a-card class="p-8">
        <h2 level="2" dark>Space & Size</h2>

        <p class="max-w-lg mt-4">
            This site uses primarily factors of 2, 4, 8, 16, 32, 64 for sizing. This relates loosely to the golden ratio 1.618~ (base font size 16px)
            and to Fibonacci, in which the first few numbers are 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233. This is important
            because the first few numbers divisible by 16 are: 16, 32, 64, 96, 128, 256. Proportions tend to be
            pleasant when size dimensions are selected along this approximate range.
        </p>

        <h2 level="2" class="mt-8" dark>Sizing units</h2>

        <div class="w-full grid grid-cols-[150px_1fr] gap-4 mt-4">
            <h3>w-64 h-64</h3>
            <div class="w-64 h-64 border-black border border-dashed bg-gray-200"></div>

            <h3>w-32 h-32</h3>
            <div class="w-32 h-32 border-black border border-dashed bg-gray-200"></div>

            <h3>w-16 h-16</h3>
            <div class="w-16 h-16 border-black border border-dashed bg-gray-200"></div>

            <h3>w-8 h-8</h3>
            <div class="w-8 h-8 border-black border border-dashed bg-gray-200"></div>

            <h3>w-4 h-4</h3>
            <div class="w-4 h-4 border-black border border-dashed bg-gray-200"></div>

            <h3>w-2 h-2</h3>
            <div class="w-2 h-2 border-black border border-dashed bg-gray-200"></div>
        </div>
    </a-card>
</template>
