<script setup>
import { useHead } from '@unhead/vue';

useHead({
    title: 'Home',
});
</script>

<template>
    <div class="">

        <div class="relative">
            <div
                class="bg-no-repeat bg-cover rounded-full h-16 w-16 border"
                style="background-image: url('/adam.png')"
            ></div>

            <div class="mt-64 mb-32">
                THE PORTFOLIO OF
            </div>

            <a-lambda class="absolute lg:ml-8 lg:mt-28" fill-hex="#fff000" :size="32"></a-lambda>
            <div class="text-2xl lg:text-5xl font-aroly text-primary">
                Adam
            </div>

            <div class="text-2xl lg:text-5xl font-aroly text-primary">
                Mackintosh
            </div>
        </div>

    </div>
</template>
