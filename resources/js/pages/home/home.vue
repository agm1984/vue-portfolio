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
                class="bg-no-repeat bg-cover rounded-full h-96 w-96 border-1 border-primary"
                style="background-image: url('/adam.png')"
            ></div>

            <div class="mt-64 mb-32">
                THE PORTFOLIO OF
            </div>

            <a-lambda class="absolute mt-0 -ml-0 lg:ml-8 lg:mt-28" fill-hex="#fff000" :size="32"></a-lambda>
            <div class="text-2xl lg:text-5xl font-aroly text-primary">
                Adam
            </div>

            <div class="text-2xl lg:text-5xl font-aroly text-primary">
                Mackintosh
            </div>
        </div>

    </div>
</template>
