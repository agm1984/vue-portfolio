<script setup>
import { useHead } from '@unhead/vue';

useHead({
    title: 'Home',
});
</script>

<template>
    <div class="p-8">
        <div class="relative">
            <div
                class="bg-no-repeat bg-cover rounded-full h-16 w-16 border"
                style="background-image: url('/adam.png')"
            ></div>

            <div class="my-8">
                THE PORTFOLIO OF
            </div>

            <a-lambda fill-hex="#000000" :size="32"></a-lambda>

            <div class="text-2xl lg:text-5xl font-aroly text-primary">
                Adam
            </div>

            <div class="text-2xl lg:text-5xl font-aroly text-primary">
                Mackintosh
            </div>
        </div>
    </div>
</template>
